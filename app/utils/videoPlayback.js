// Coordinate uploaded videos across the home page and service blocks.
export function pauseOtherVideos(event) {
  const current = event.currentTarget;
  document.querySelectorAll("video[data-exclusive-playback]").forEach((video) => {
    if (video !== current && !video.paused) {
      // Keep the position so returning to this video resumes where it stopped.
      video.pause();
    }
  });
}
