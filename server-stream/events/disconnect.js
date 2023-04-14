import { transcodeVideo } from "../utils/function.js";

export default (socket, user, file) => {
  if (user.action == "live") {
    // disconnect-with is a event handled by RTCMultiConnectionServer to disconnect a specific socket
    socket.emit("disconnect-with", socket.client.conn.id);
  }

  if (user.role == "streamer") {
    console.log("Fin d'un stream");

    if (file && file.tempFile) {
      file.tempFile.end();
      transcodeVideo(user, file);
    } else {
      console.log("Pas de fichier à transcoder");
    }

    // TO DO : Déconnecter tous les viewers
  } else if (user.role == "viewer") {
    console.log("Viewer disconnected");
  }
};
