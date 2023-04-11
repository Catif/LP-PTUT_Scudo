import { initFileVar } from "../utils/function.js";

export default (event, user, file) => {
	console.log("Initialisation de l'utilisateur");

	user.role = event.role;
	if (user.role == "streamer") {
		user.token = event.token;
		console.log("Streamer connected");
		initFileVar(file, event.room);
	} else if (user.role == "viewer") {
		console.log("Viewer connected");
	}
};
