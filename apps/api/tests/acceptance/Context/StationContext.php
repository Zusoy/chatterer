<?php

declare(strict_types=1);

namespace Test\Acceptance\Context;

use Domain\Model\Station;
use Domain\Model\User;
use Infra\Assert\Assert;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;
use Test\Acceptance\Context;

final class StationContext extends Context
{
    private ?string $stationName = null;
    private ?string $stationDescription = null;
    private ?string $emailAddress = null;

    /**
     * @var Station[]
     */
    private array $stations = [];

    /**
     * @BeforeScenario
     */
    public function reset(): void
    {
        $this->stationName = null;
        $this->stationDescription = null;
        $this->emailAddress = null;
        $this->stations = [];

        $this->database->truncate();
    }

    /**
     * @Given I am a visitor
     */
    public function iAmAVisitor(): void
    {
    }

    /**
     * @Given I am a user
     */
    public function iAmAUser(): void
    {
        $this->emailAddress = $this->faker->email();

        /** @var User */
        $user = $this->faker->user($this->emailAddress);

        $this->database->users->add($user);
        $this->http->auth($this->emailAddress);
    }

    /**
     * @Given I am an admin
     */
    public function iAmAnAdmin(): void
    {
        $this->emailAddress = $this->faker->email();

        /** @var User */
        $user = $this->faker->admin($this->emailAddress);

        $this->database->users->add($user);
        $this->http->auth($this->emailAddress);
    }

    /**
     * @When I create a new station
     */
    public function iCreateANewStation(): void
    {
        $this->stationName = $this->faker->company();
        $this->stationDescription = $this->faker->sentence(10);

        $this->http->post('/stations', [
            'name' => $this->stationName,
            'description' => $this->stationDescription
        ]);
    }

    /**
     * @Given There is some existing stations
     */
    public function thereIsSomeExistingStations(): void
    {
        foreach (range(1, 12) as $iteration) {
            $station = $this->faker->station();
            $this->database->stations->add($station);

            $this->stations[] = $station;
        }
    }

    /**
     * @Then I can list all stations
     */
    public function thenICanListAllStations(): void
    {
        $response = $this->http->get('/stations');
        $data = $this->http->getLastJson();

        $this->validateJsonSchema(
            $this->http->getLastJsonObjects(),
            schema: 'stations'
        );

        Assert::that($response->headers->get('X-Total-Count'))
            ->eq(count($this->stations));

        /** @var string[] */
        $expectedNames = array_map(
            static fn (Station $station): string => $station->getName(),
            $this->stations
        );

        /** @var string[] */
        $realityNames = array_map(
            static fn (array $station): string => $station['name'],
            $data
        );

        $assertion = Assert::lazy();

        foreach ($expectedNames as $name) {
            $assertion->that(in_array(needle: $name, haystack: $realityNames));
        }

        $assertion->verifyNow();
    }

    /**
     * @Then I should be able to see my new station
     */
    public function thenIShouldBeAbleToSeeMyNewStation(): void
    {
        if ($this->stationName === null) {
            throw new RuntimeException('No station created.');
        }

        $response = $this->http->get('/stations');
        $data = $this->http->getLastJson();

        $names = array_map(
            static fn (array $station): string => $station['name'],
            $data
        );

        Assert::that($response->getStatusCode())->eq(200);
        Assert::that(in_array(needle: $this->stationName, haystack: $names))->true();
    }

    /**
     * @Then I should be notified that I cannot list stations
     */
    public function thenIShouldBeNotifiedThatICannotListStations(): void
    {
        $response = $this->http->get('/stations');
        $payload = $this->http->getLastJson();

        Assert::that($response->getStatusCode())->eq(Response::HTTP_UNAUTHORIZED);
        Assert::that($payload)->keyExists('error');
        Assert::that(preg_match('/Full authentication is required/', $payload['error']['message']))->eq(1);
    }

    /**
     * @Then I should be notified that I don't have permission to create
     */
    public function thenIShouldBeNotifiedThatIDontHavePermissionToCreate(): void
    {
        if (!$response = $this->http->getLastResponse()) {
            throw new RuntimeException('No station created.');
        }

        $data = $this->http->getLastJson();

        Assert::that($response->getStatusCode())->eq(403);
        Assert::that($data)->keyExists('error');
        Assert::that(preg_match('/Operation \'station:create\' is not permitted./', $data['error']['message']))->eq(1);
    }
}
