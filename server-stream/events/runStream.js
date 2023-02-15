import RTCMultiConnectionServer from "rtcmulticonnection-server";

export default (socket) => {
  RTCMultiConnectionServer.addSocket(socket);
};
