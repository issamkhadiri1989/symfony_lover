<?php

namespace App\Tests\App\Service;

use App\Service\Mailer;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\MailerInterface;

/**
 * This class contains the unit tests of the Mail service.
 */
class MailerTest extends KernelTestCase
{
    /**
     * Unit testing sending email with no errors.
     *
     * @dataProvider dataProvider
     *
     * @param string $toAddress
     * @param string $fromAddress
     *
     * @return void
     */
    public function testSendMailOk(string $toAddress, string $fromAddress): void
    {
        $mock = $this->getMockBuilder(MailerInterface::class)
            ->onlyMethods(['send'])
            ->disableOriginalConstructor()
            ->getMock();
        $mailer = new Mailer($mock, $fromAddress);
        $mock->expects($this->once())
            ->method('send');
        $sent = $mailer->sendConfirmationMail($toAddress, 'some dummy subject');
        $this->assertTrue($sent);
    }

    /**
     * Unit testing sending email with some error.
     *
     * @dataProvider dataProvider
     *
     * @param string $toAddress
     * @param string $fromAddress
     *
     * @return void
     */
    public function testSendMailWithError(string $toAddress, string $fromAddress): void
    {
        $mock = $this->getMockBuilder(MailerInterface::class)
            ->onlyMethods(['send'])
            ->disableOriginalConstructor()
            ->getMock();
        $mock->method('send')
            ->willThrowException(new TransportException('Something went wring'));
        $mailer = new Mailer($mock, $fromAddress);
        $mock->expects($this->once())
            ->method('send');
        $sent = $mailer->sendConfirmationMail($toAddress, 'some dummy subject');
        $this->assertFalse($sent);
    }

    public function dataProvider()
    {
        return [
            ['test@gmail.com', 'from@example.com']
        ];
    }
}