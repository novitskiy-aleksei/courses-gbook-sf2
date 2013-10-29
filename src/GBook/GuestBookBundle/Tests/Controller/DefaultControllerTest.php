<?php

namespace GBook\GuestBookBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    /**
     * Проверяем, загрузилась ли главная страница
     * и есть ли на ней форма с нужными элементами
     */
    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertTrue($client->getResponse()->getStatusCode() == 200);
//        $this->assertTrue($crawler->filter('html:contains("Hello Fabien")')->count() > 0);
        $this->assertTrue($crawler->filter('form.auth-form')->count() > 0);
        $this->assertTrue($crawler->filter("form.auth-form input[name='title']")->count() > 0);
        $this->assertTrue($crawler->filter("form.auth-form input[name='author']")->count() > 0);
        $this->assertTrue($crawler->filter("form.auth-form textarea[name='text']")->count() > 0);
        $this->assertTrue($crawler->filter("form.auth-form button[type='submit']")->count() > 0);
    }

    /**
     * Проверка на возможность запостить сообщение
     */
    public function testPosting()
    {
        $text = uniqid('test_');
        $client = static::createClient();
        $client->request('POST', '/post', [
            'title'  => 'test',
            'author' => 'tester',
            'text'   => $text,
        ]);
        $crawler = $client->request('GET', '/');

        $this->assertTrue($crawler->filter('html:contains("'.$text.'")')->count() > 0);
    }
}
