<?php

namespace App\Tests\App\Controller;

use Symfony\Bundle\FrameworkBundle\Test\MailerAssertionsTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * This class contains the functional tests of the Mail service.
 */
class MailerControllerTest extends WebTestCase
{
    use MailerAssertionsTrait;

    /**
     * Perform functional testing.
     *
     * @dataProvider emailCountProvider
     *
     * @param int    $expectedEmailCount the expected number of emails to be sent
     * @param string $senderName         the name of the sender that should be included in the email's body
     *
     * @return void
     */
    public function testSendMail(int $expectedEmailCount, string $senderName): void
    {
        $client = $this->createClient();
        $client->request('GET', '/example-mail');
        // first we need to be sure that the page has been successfully loaded
        $this->assertResponseIsSuccessful();
        // check that the expected number of email matches the real number of emails sent.
        $this->assertEmailCount($expectedEmailCount);
        // get the current email
        $email = $this->getMailerMessage();
        // check that the html body of the email contains some text
        $this->assertEmailHtmlBodyContains($email, 'Welcome '.$senderName);
    }

    /**
     * a dummy example of data provider just to get familiar with.
     *
     * @return \int[][]
     */
    public function emailCountProvider(): array
    {
        return [
            [1, 'Issam KHADIRI']
        ];
    }
}