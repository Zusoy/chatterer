<?php

namespace Application\CLI;

use Doctrine\ORM\EntityManagerInterface;
use Domain\Bus;
use Domain\Message\Channel as ChannelMessage;
use Domain\Message\Message as MessagesMessage;
use Domain\Message\Station as StationMessage;
use Domain\Message\User as UserMessage;
use Domain\Model\Channel;
use Domain\Model\Message;
use Domain\Model\Station;
use Domain\Model\User;
use Domain\Security\UserProvider;
use Faker\Generator;
use Infra\Doctrine\Truncater;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Throwable;

#[AsCommand(name: 'app:data:fixtures')]
final class InsertFixturesCommand extends Command
{
    private const ADMIN_COUNT = 2;
    private const USER_COUNT = 6;
    private const STATION_COUNT = 2;
    private const CHANNEL_COUNT = 3;
    private const MESSAGE_COUNT = 50;

    /**
     * @var array{admins: User[], users: User[], stations: Station[], channels: Channel[]}
     */
    private array $references = [
        'admins'   => [],
        'users'    => [],
        'stations' => [],
        'channels' => []
    ];

    /**
     * @var array<string, int>
     */
    private array $counts = [
        'admins'   => 0,
        'users'    => 0,
        'stations' => 0,
        'channels' => 0,
        'messages' => 0
    ];

    public function __construct(
        private Bus $bus,
        private Generator $domainGenerator,
        private EntityManagerInterface $entityManager,
        private UserProvider $userProvider
    ) {
        parent::__construct();
    }

    /**
     * {@inheritDoc}
     */
    protected function configure(): void
    {
        $this
            ->setDescription('Insert fake data into database')
            ->addOption('prune', 'p', InputOption::VALUE_NONE, 'Wipe all data before');
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            if ($input->getOption('prune')) {
                $io->warning('Wiping all data...');

                $this->prune();
            }

            $io->info('Inserting fixtures...');
            $this->insert();
            $io->success('Done.');

            $io->section('Inserted data');
            $io->horizontalTable(
                array_keys($this->counts),
                [array_values($this->counts)]
            );

            $io->comment('Memory usage: '.memory_get_peak_usage(true) / 1024 / 1024 .' MB');

            return Command::SUCCESS;
        } catch (Throwable $error) {
            $io->error("ERROR : {$error->getMessage()}");

            return Command::FAILURE;
        }
    }

    private function prune(): void
    {
        $truncater = new Truncater($this->entityManager->getConnection());
        $truncater->truncateAll();
    }

    private function insert(): void
    {
        $this->insertMainAdmin();
        $this->insertAdmins();
        $this->insertUsers();

        $this->insertMainData();
    }

    private function insertMainAdmin(): void
    {
        $admin = $this->domainGenerator->admin('chatterer@admin.com');

        $this->entityManager->persist($admin);
        $this->entityManager->flush();

        $this->references['admins'][] = $admin;
        $this->count('admins');

        $this->userProvider->setCurrent($admin);
    }

    private function insertAdmins(): void
    {
        for ($a = 0; $a < self::ADMIN_COUNT; ++$a) {
            /** @var User */
            $admin = $this->domainGenerator->admin($this->domainGenerator->email());

            $newAdmin = $this->bus->execute(new UserMessage\Create(
                firstname: $admin->getFirstname(),
                lastname: $admin->getLastname(),
                email: $admin->getEmail(),
                password: $admin->getEmail(),
                isAdmin: true
            ));

            $this->references['admins'][] = $newAdmin;
            $this->count('admins');
        }
    }

    private function insertUsers(): void
    {
        for ($u = 0; $u < self::USER_COUNT; ++$u) {
            /** @var User */
            $user = $this->domainGenerator->user($this->domainGenerator->email());

            $newUser = $this->bus->execute(new UserMessage\Create(
                firstname: $user->getFirstname(),
                lastname: $user->getLastname(),
                email: $user->getEmail(),
                password: $user->getEmail(),
                isAdmin: false
            ));

            $this->references['users'][] = $newUser;
            $this->count('users');
        }
    }

    private function insertMainData(): void
    {
        for ($s = 0; $s < self::STATION_COUNT; ++$s) {
            /** @var Station */
            $station = $this->domainGenerator->station();

            $newStation = $this->bus->execute(new StationMessage\Create(
                name: $station->getName(),
                description: $station->getDescription()
            ));

            $this->references['stations'][] = $newStation;
            $this->count('stations');
        }

        foreach ($this->references['stations'] as $station) {
            for ($c = 0; $c < self::CHANNEL_COUNT; ++$c) {
                /** @var Channel */
                $channel = $this->domainGenerator->channel([ $station ]);

                $newChannel = $this->bus->execute(new ChannelMessage\Create(
                    stationId: (string) $station->getIdentifier(),
                    name: $channel->getName(),
                    description: $channel->getDescription()
                ));

                $this->references['channels'][] = $newChannel;
                $this->count('channels');
            }
        }

        foreach ($this->references['channels'] as $channel) {
            for ($m = 0; $m < self::MESSAGE_COUNT; ++$m) {
                /** @var Message */
                $message = $this->domainGenerator->message(
                    $this->references['users'],
                    [ $channel ]
                );

                $newMessage = $this->bus->execute(new MessagesMessage\Create(
                    authorId: (string) $message->getAuthorIdentifier(),
                    channelId: (string) $channel->getIdentifier(),
                    content: $message->getContent()
                ));

                $this->references['messages'][] = $newMessage;
                $this->count('messages');
            }
        }
    }

    private function count(string $type, int $increment = 1): void
    {
        $this->counts[$type] += $increment;
    }
}
