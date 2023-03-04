Feature: Create Station
  In order to have differents stations
  As an admin
  I need to be able to create new station

  Scenario: Create a new station as admin
    Given I am an admin
    When I create a new station
    Then I should be able to see my new station

  Scenario: Fail to create a station as regular user
    Given I am a user
    When I create a new station
    Then I should be notified that I don't have permission to create
