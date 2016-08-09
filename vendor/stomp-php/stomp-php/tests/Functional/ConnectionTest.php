<?php

namespace FuseSource\Tests\Functional;

use FuseSource\Stomp\Connection;
use FuseSource\Stomp\Exception\ConnectionException;
use FuseSource\Stomp\Exception\ErrorFrameException;
use FuseSource\Stomp\Frame;
use PHPUnit_Framework_TestCase;
/**
 *
 * Copyright 2005-2006 The Apache Software Foundation
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
/* vim: set expandtab tabstop=3 shiftwidth=3: */

/**
 * Stomp test case.
 * @package Stomp
 * @author Jens Radtke <swefl.oss@fin-sn.de>
 */
class ConnectionTest extends PHPUnit_Framework_TestCase
{
    function testReadFrameThrowsExceptionIfStreamIsBroken()
    {
        $connection = $this->getMockBuilder('\FuseSource\Stomp\Connection')
            ->setMethods(array('hasDataToRead', '_connect'))
            ->setConstructorArgs(array('tcp://host'))
            ->getMock();

        $fp = tmpfile();

        $connection->expects($this->once())->method('_connect')->will($this->returnValue($fp));
        $connection->expects($this->once())->method('hasDataToRead')->will($this->returnValue(true));

        $connection->connect();
        fclose($fp);
        try {
            $connection->readFrame();
            $this->fail('Expected a exception!');
        } catch (ConnectionException $excpetion) {
            $this->assertContains('Was not possible to read data from stream.', $excpetion->getMessage());
        }
    }

    function testReadFrameThrowsExceptionIfErrorFrameIsReceived()
    {
        $connection = $this->getMockBuilder('\FuseSource\Stomp\Connection')
            ->setMethods(array('hasDataToRead', '_connect'))
            ->setConstructorArgs(array('tcp://host'))
            ->getMock();

        $fp = tmpfile();

        fwrite($fp, "ERROR\nmessage:stomp-err-info\n\nbody\x00");
        fseek($fp, 0);

        $connection->expects($this->once())->method('_connect')->will($this->returnValue($fp));
        $connection->expects($this->once())->method('hasDataToRead')->will($this->returnValue(true));

        $connection->connect();

        try {
            $connection->readFrame();
            $this->fail('Expected a exception!');
        } catch (ErrorFrameException $excpetion) {
            $this->assertContains('stomp-err-info', $excpetion->getMessage());
            $this->assertEquals('body', $excpetion->getFrame()->body);
        }
        fclose($fp);
    }

    function testWriteFrameThrowsExceptionIfConnectionIsBroken()
    {
        $connection = $this->getMockBuilder('\FuseSource\Stomp\Connection')
            ->setMethods(array('_connect'))
            ->setConstructorArgs(array('tcp://host'))
            ->getMock();



        $name = tempnam(sys_get_temp_dir(), 'stomp');
        $fp = fopen($name, 'r');

        $connection->expects($this->once())->method('_connect')->will($this->returnValue($fp));

        $connection->connect();

        try {
            $connection->writeFrame(new Frame('TEST'));
            $this->fail('Expected a exception!');
        } catch (ConnectionException $excpetion) {
            $this->assertContains('Was not possible to write frame!', $excpetion->getMessage());
        }
        fclose($fp);
    }

    function testHasDataToReadThrowsExceptionIfConnectionIsBroken()
    {
        $connection = $this->getMockBuilder('\FuseSource\Stomp\Connection')
            ->setMethods(array('isConnected', '_connect'))
            ->setConstructorArgs(array('tcp://host'))
            ->getMock();

        $fp = tmpfile();

        $connection->expects($this->once())->method('_connect')->will($this->returnValue($fp));

        $connected = false;
        $connection->expects($this->exactly(2))
            ->method('isConnected')
            ->will(
                $this->returnCallback(
                    function () use (&$connected) {
                        return $connected;
                    }
                )
            );

        $connection->connect();
        $connected = true;
        fclose($fp);
        try {
            $connection->readFrame();
            $this->fail('Expected a exception!');
        } catch (ConnectionException $excpetion) {
            $this->assertContains('Check failed to determine if the socket is readable', $excpetion->getMessage());
        }
    }

    function testConnectionFailLeadsToException()
    {
        $connection = new Connection('tcp://0.0.0.1:15');
        try {
            $connection->connect();
            $this->fail('Expected an exception!');
        } catch (ConnectionException $ex) {
            $this->assertContains('Could not connect to a broker', $ex->getMessage());

            $this->assertInstanceOf('FuseSource\Stomp\Exception\ConnectionException', $ex->getPrevious(), 'There should be a previous exception.');
            $prev = $ex->getPrevious();
            $hostinfo = $prev->getConnectionInfo();
            $this->assertEquals('0.0.0.1', $hostinfo['host']);
            $this->assertEquals('15', $hostinfo['port']);

        }
    }

    function testConnectionWillReturnBufferedFramesIfMoreThanOneWasReturnedInLastRead()
    {
        $connection = $this->getMockBuilder('\FuseSource\Stomp\Connection')
            ->setMethods(array('hasDataToRead', '_connect'))
            ->setConstructorArgs(array('tcp://host'))
            ->getMock();

        $fp = tmpfile();

        fwrite($fp, "INFO\nmsgno:1\n\nbody1\x00" . PHP_EOL);
        fwrite($fp, "INFO\nmsgno:22\n\nbody22\x00");
        fwrite($fp, "INFO\nmsgno:333\n\nbody333\x00" . PHP_EOL);
        fwrite($fp, "INFO\nmsgno:4\n\nbody\x00");
        fseek($fp, 0);

        $connection->expects($this->once())->method('_connect')->will($this->returnValue($fp));
        $connection->expects($this->once())->method('hasDataToRead')->will($this->returnValue(true));

        $connection->connect();

        $firstFrame = $connection->readFrame();
        fclose($fp);

        // even if connection is closed, there must be known frames...
        $secondFrame = $connection->readFrame();
        $thirdFrame = $connection->readFrame();
        $fourthFrame = $connection->readFrame();

        $this->assertEquals('body1', $firstFrame->body);
        $this->assertEquals('body22', $secondFrame->body);
        $this->assertEquals('body333', $thirdFrame->body);
        $this->assertEquals('body', $fourthFrame->body);
    }

}

