<?php

declare(strict_types=1);

namespace Test\Acceptance\Context;

use Behat\Gherkin\Node\TableNode;
use Domain\Model\Station;
use Infra\Assert\Assert;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;
use Test\Acceptance\Context;

final class Stations extends Context
{
    /**
     * @var Station[]
     */
    private array $stations = [];

    /**
     * @BeforeScenario
     */
    public function reset(): void
    {
        $this->stations = [];

        $this->persistence->clear();
    }

    /**
     * @Given There is some stations
     */
    public function thereIsSomeStations(TableNode $table): void
    {
        foreach ($table->getColumnsHash() as $row) {
            $station = new Station(
                name: $row['name'],
                description: $row['description']
            );

            $this->stations[] = $station;
            $this->persistence->manager->persist($station);
        }

        $this->persistence->manager->flush();
    }

    /**
     * @When I list stations
     */
    public function iListStations(): void
    {
        $this->http->get('/stations');
    }

    /**
     * @Then I should see the list of all stations
     */
    public function iShouldSeeTheListOfAllStations(): void
    {
        if (!$response = $this->http->getLastResponse()) {
            throw new RuntimeException('No requests during this scenario.');
        }

        Assert::that($response->getStatusCode())->eq(Response::HTTP_OK);

        $this->validateJsonSchema(
            $this->http->getLastJsonObjects(),
            schema: 'stations'
        );
    }
}
