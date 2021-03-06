<?php
/**
 * @author Oliver Lorenz
 * @since 2015-04-24
 * Time: 19:40
 */

namespace oliverlorenz\reactphpmqtt\packet;

class Factory {

    /**
     * @param $version
     * @param $input
     * @return null|ControlPacket
     */
    public static function getByMessage($version, $input)
    {
        $message = null;
        if(empty($input)) {
            throw new \InvalidArgumentException();
        }
        $packetControlType = ord($input{0}) >> 4;
        switch ($packetControlType) {
            case ConnectionAck::getControlPacketType():
                $message = new ConnectionAck($version, $input);
                break;
            case PingResponse::getControlPacketType():
                $message = new PingResponse($version, $input);
                break;
            case SubscribeAck::getControlPacketType():
                $message = new SubscribeAck($version, $input);
                break;
            case Publish::getControlPacketType():
                $message = Publish::parse($version, $input);
                break;
            case PublishComplete::getControlPacketType():
                $message = PublishComplete::parse($version, $input);
                break;
            case PublishRelease::getControlPacketType():
                $message = PublishRelease::parse($version, $input);
                break;
            case PublishReceived::getControlPacketType():
                $message = PublishReceived::parse($version, $input);
                break;
            default:
                throw new \InvalidArgumentException('got message with control packet type ' . $packetControlType);
            }
        return $message;
    }

}