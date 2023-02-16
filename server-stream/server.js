// NodeJS
import { createServer } from "http";

// Node modules
import express from "express";
import { Server } from "socket.io";

// Variables de configuration
import conf from "./conf/configuration.js";

// Déclaration des variables
const app = express();
const httpServer = createServer(app);
const io = new Server(httpServer, {
  cors: {
    origin: "*",
    methods: ["GET", "POST"],
  },
});

// Gestion des événements WebSocket (socket.io)
import events from "./events/index.js";
events(io);

// Gestion des événements api (express)
import api from "./api/index.js";
api(app);

// Lancement
httpServer.listen(conf.port);

console.log("Lancement du serveur sur le port " + conf.port);
