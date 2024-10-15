<?php

namespace App\Tests\Controller;

use App\Entity\Media;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class MediaControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/media/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Media::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Medium index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'medium[titre]' => 'Testing',
            'medium[texte]' => 'Testing',
            'medium[image]' => 'Testing',
            'medium[media]' => 'Testing',
            'medium[aime]' => 'Testing',
            'medium[consomme]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Media();
        $fixture->setTitre('My Title');
        $fixture->setTexte('My Title');
        $fixture->setImage('My Title');
        $fixture->setMedia('My Title');
        $fixture->setAime('My Title');
        $fixture->setConsomme('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Medium');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Media();
        $fixture->setTitre('Value');
        $fixture->setTexte('Value');
        $fixture->setImage('Value');
        $fixture->setMedia('Value');
        $fixture->setAime('Value');
        $fixture->setConsomme('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'medium[titre]' => 'Something New',
            'medium[texte]' => 'Something New',
            'medium[image]' => 'Something New',
            'medium[media]' => 'Something New',
            'medium[aime]' => 'Something New',
            'medium[consomme]' => 'Something New',
        ]);

        self::assertResponseRedirects('/media/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitre());
        self::assertSame('Something New', $fixture[0]->getTexte());
        self::assertSame('Something New', $fixture[0]->getImage());
        self::assertSame('Something New', $fixture[0]->getMedia());
        self::assertSame('Something New', $fixture[0]->getAime());
        self::assertSame('Something New', $fixture[0]->getConsomme());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Media();
        $fixture->setTitre('Value');
        $fixture->setTexte('Value');
        $fixture->setImage('Value');
        $fixture->setMedia('Value');
        $fixture->setAime('Value');
        $fixture->setConsomme('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/media/');
        self::assertSame(0, $this->repository->count([]));
    }
}
