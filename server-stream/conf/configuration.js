function patternFilename(file, room) {
	file.id = room;
	file.filename = `video-${file.id}`;
}

const conf = {
	// The port to listen on
	port: process.env.PORT || 3000,

	api_url: "https://api.scudo.catif.me",

	// The path to the folder where the videos will be stored
	folderTemp: "./video/temp",
	folderOutput: "./video/transcode",

	// Setting transcode
	transcode: {
		extensionFile: "mp4",
		codec: "libx264", // libx264, libx265, libvpx, libvpx-vp9, libaom-av1
		preset: "ultrafast", // Processeur => test avec 1min de vidéo : ultrafast (10s), superfast(21s), veryfast(24s), faster(34s), fast(36s), medium, slow, slower, veryslow
		quality: 22, // Stockage => test avec 1min de vidéo : 0 (100-150Mo) à 51 (3Mo)  ==>  15 (70Mo)
	},

	// Pattern filename
	createFilename: patternFilename,
};

export default conf;
