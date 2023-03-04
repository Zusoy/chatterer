Feature: List Stations
  In order to see available stations
  As a connected user
  I need to access to all stations

  Scenario: List all stations
    Given I am a user
    When There is some existing stations
    Then I can list all stations

  Scenario: Unable to list stations as visitor
    Given I am a visitor
    When There is some existing stations
    Then I should be notified that I cannot list stations
