Feature: Update Station
  In order to manage stations
  As an admin
  I need to be able to update a station

  Scenario: Update a station as admin
    Given I am an admin
    And There is an existing "Test" station
    When I update the station with name "Other" and description "Desc"
    Then I should be notified that the station is updated

  Scenario: Not authorized to update a station as regular user
    Given I am a user
    And There is an existing "Test" station
    When I update the station with name "Other" and description "Desc"
    Then I should be notified that I'm not authorized for operation "station:update"
