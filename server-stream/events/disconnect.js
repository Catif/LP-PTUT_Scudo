import { transcodeVideo } from "../utils/function.js";

export default (socket, user, file) => {
  if (user.action == "live") {
    // disconnect-with is a event handled by RTCMultiConnectionServer to disconnect a specific socket
    socket.emit("disconnect-with", socket.client.conn.id);
  }
  if (user.role == "streamer") {
    console.log("Fin d'un stream");

    file.tempFile.end();
    transcodeVideo(file.filename);

    // TO DO : Déconnecter tous les viewers
  } else if (user.role == "viewer") {
    console.log("Viewer disconnected");
  }
};
