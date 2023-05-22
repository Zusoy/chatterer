Feature: Create Station
  In order to manage stations
  As an admin
  I need to be able to create new station

  Scenario: Create a new station as admin
    Given I am an admin
    When I create a new station with
      | name | description |
      | Test | lorem ipsum |
    Then I should be notified that the station is created

  Scenario: Not authorized to create a station as regular user
    Given I am a user
    When I create a new station with
      | name | description |
      | Test | lorem ipsum |
    Then I should be notified that I'm not authorized for operation "station:create"
