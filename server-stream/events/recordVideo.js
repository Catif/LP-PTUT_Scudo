import { createWriteStream } from "fs";
import conf from "../conf/configuration.js";

export default (event, user, file) => {
  if (user.role == "streamer") {
    if (!file.tempFile) {
      console.log("Stream started");
      file.tempFile = createWriteStream(`${conf.folderTemp}/${file.filename}.tmp`);
    }
    file.tempFile.write(event.video);
  }
};
