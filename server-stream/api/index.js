import home from "./home.js";
import video from "./video.js";

export default (app) => {
  // '/'
  home(app);

  // '/api/video'
  video(app);
};
