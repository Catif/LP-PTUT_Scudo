// Importation des modules
import { access } from "../utils/function.js";

// Importation des fonctions de gestion des événements
import initUser from "./initUser.js";
import runStream from "./runStream.js";
import recordVideo from "./recordVideo.js";
import disconnect from "./disconnect.js";

export default (io) => {
  io.on("connection", (socket) => {
    console.log("New connection");

    // Vérification des paramètres de connexion au serveur
    access(socket, socket.handshake.query);

    // Variables globales
    var user = {};
    var file = {};

    // Ajout des roles
    socket.on("initUser", (event) => {
      initUser(event, user, file);
    });

    // Ajout du socket à la liste des sockets de RTCMultiConnectionServer
    socket.on("runStream", (event) => {
      runStream(socket);
    });

    socket.on("recordVideo", (event) => {
      recordVideo(event, user, file);
    });

    socket.on("disconnect", (event) => {
      disconnect(socket, user, file);
    });
  });
};
