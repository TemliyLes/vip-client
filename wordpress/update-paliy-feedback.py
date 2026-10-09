#!/usr/bin/env python3
"""Update the installed PALIY feedback languages without replacing other code.

Usage: python3 update-paliy-feedback.py /absolute/path/to/paliy-product-crop.php
Requires PHP CLI (local or --php-container) before replacing the original file.
"""

import argparse
import os
from pathlib import Path
import shutil
import subprocess
import tempfile


REPLACEMENTS = [
    (" * Version: 2.28.0", " * Version: 2.28.1", 1),
    ("define('PALIY_PRODUCT_CROP_VERSION', '2.28.0');",
     "define('PALIY_PRODUCT_CROP_VERSION', '2.28.1');", 1),
    ('<option value="en" <?php selected($language, \'en\'); ?>>English</option>',
     '<option value="sk" <?php selected($language, \'sk\'); ?>>Slovenčina</option>', 1),
    ("['cs', 'en']", "['cs', 'sk']", 2),
    ("$subject = $language === 'en' ? 'New inquiry from PALIY website' : 'Nová poptávka z webu PALIY';",
     "$subject = $language === 'sk' ? 'Nový dopyt z webu PALIY' : 'Nová poptávka z webu PALIY';", 1),
    (r'''$body = $language === 'en'
        ? "New inquiry from the PALIY website.\n\nName: {$name}\nPhone: {$phone}\nService: {$service_title}\nPage: {$page_title}\nURL: {$page_url}\n\nMessage:\n{$message}\n\nRequest ID: {$post_id}"''',
     r'''$body = $language === 'sk'
        ? "Nový dopyt z webu PALIY.\n\nMeno: {$name}\nTelefón: {$phone}\nSlužba: {$service_title}\nStránka: {$page_title}\nOdkaz: {$page_url}\n\nSpráva:\n{$message}\n\nID žiadosti: {$post_id}"''', 1),
    ("'message' => $language === 'en'\n            ? 'Thank you. Your inquiry has been sent.'",
     "'message' => $language === 'sk'\n            ? 'Ďakujeme. Váš dopyt bol odoslaný.'", 1),
]


def main():
    parser = argparse.ArgumentParser(description=__doc__)
    parser.add_argument("plugin_file", type=Path)
    parser.add_argument("--php-container", help="Use PHP CLI inside this existing Docker container")
    args = parser.parse_args()
    target = args.plugin_file.resolve(strict=True)
    if target.name != "paliy-product-crop.php" or target.parent.name != "paliy-product-crop":
        raise SystemExit("Expected paliy-product-crop/paliy-product-crop.php")
    php = shutil.which("php")
    docker = shutil.which("docker") if args.php_container else None
    if not (docker or php):
        raise SystemExit("PHP CLI or Docker --php-container is required; nothing was changed")

    original = target.read_bytes()
    newline = "\r\n" if b"\r\n" in original else "\n"
    source = original.decode("utf-8").replace("\r\n", "\n")
    expected = source
    for old, new, count in REPLACEMENTS:
        if expected.count(old) != count:
            raise SystemExit(f"Source mismatch for {old[:80]!r}; nothing was changed")
        expected = expected.replace(old, new)
    updated = expected.replace("\n", newline).encode("utf-8")

    # Keep the complete original outside the plugin directory and the web root.
    backup_dir = Path.home() / "paliy-plugin-backups"
    backup_dir.mkdir(mode=0o700, exist_ok=True)
    descriptor, backup_name = tempfile.mkstemp(prefix="paliy-2.28.0-", suffix=".php", dir=backup_dir)
    with os.fdopen(descriptor, "wb") as backup:
        backup.write(original)

    descriptor, temp_name = tempfile.mkstemp(prefix=".paliy-feedback-", suffix=".php", dir=target.parent)
    temporary = Path(temp_name)
    try:
        with os.fdopen(descriptor, "wb") as output:
            output.write(updated)
            output.flush()
            os.fsync(output.fileno())
        if docker:
            subprocess.run([docker, "exec", "-i", args.php_container, "php", "-l"], input=updated, check=True)
        else:
            subprocess.run([php, "-l", str(temporary)], check=True)
        if target.read_bytes() != original:
            raise SystemExit("Plugin changed during preparation; nothing was replaced")
        stat = target.stat()
        os.chmod(temporary, stat.st_mode & 0o7777)
        if hasattr(os, "chown"):
            os.chown(temporary, stat.st_uid, stat.st_gid)
        os.replace(temporary, target)
    finally:
        temporary.unlink(missing_ok=True)
    print(f"Updated: {target} (2.28.1)")
    print(f"Backup: {backup_name}")


if __name__ == "__main__":
    main()
