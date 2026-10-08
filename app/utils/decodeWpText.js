import { decode, EntityLevel } from "entities";

export function decodeWpText(value) {
  if (typeof value !== "string" || !value.includes("&")) return value ?? "";

  return decode(value, { level: EntityLevel.HTML });
}
