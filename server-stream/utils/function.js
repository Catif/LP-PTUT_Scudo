import conf from "../conf/configuration.js";
import ffmpeg from "fluent-ffmpeg";
import { statSync, unlinkSync, existsSync, mkdirSync } from "fs";

// ==============================
//          fonctions
// ==============================
export function access(socket, params) {
	if (!params.sessionid && params.socketEventCustom && !params.msgEvent) {
		console.log("Client disconnected caused by bad parameters");
		socket.disconnect();
	}
}

export function initFileVar(file, room) {
	file.tempFile = null;
	conf.createFilename(file, room);

	if (!existsSync(conf.folderTemp)) {
		mkdirSync(conf.folderTemp, { recursive: true });
	}
}

export function getStatFile(file, durationTranscode) {
	const BYTES_MO = 1024 * 1024;
	let fileSizeInBytes = statSync(file).size;
	let fileSizeInMegabytes = fileSizeInBytes / BYTES_MO;
	let sizeMo = Math.round(fileSizeInMegabytes * 100) / 100;

	ffmpeg.ffprobe(file, (err, metadata) => {
		let duration = Math.round(100 * metadata.format.duration) / 100;
		console.log(
			`Fichier crée : ${file} | durée de la vidéo : ${duration} s  | taille : ${sizeMo} Mo | temps de conversion : ${durationTranscode} s`
		);
	});
}

export function transcodeVideo(file) {
	if (!existsSync(conf.folderOutput)) {
		mkdirSync(conf.folderOutput, { recursive: true });
	}

	// Path
	let pathFileTemp = `${conf.folderTemp}/${file.filename}.tmp`;
	let pathFileTranscode = `${conf.folderOutput}/${file.filename}.${conf.transcode.extensionFile}`;

	console.log("Début de la conversion");

	// Transcode
	let startTime = performance.now();
	ffmpeg()
		.input(pathFileTemp)
		.withVideoCodec(conf.transcode.codec)
		.addOption("-preset", conf.transcode.preset)
		.addOption("-crf", conf.transcode.quality)
		.output(pathFileTranscode)
		.on("end", () => {
			// Calcul du temps de conversion
			let endTime = performance.now();
			let durationTranscode = Math.round(endTime - startTime) / 1000;

			console.log("Conversion complete");

			fetch(`${conf.api_url}/api/resource/${file.id}`, {
				method: "POST",
				body: JSON.stringify({ type: "video" }),
			});

			getStatFile(pathFileTranscode, durationTranscode);
			unlinkSync(pathFileTemp); // Delete file temp
		})
		.run();
}

export default () => {
	access, initFileVar, transcodeVideo;
};
