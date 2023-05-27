Feature: Update a Channel
  In order to manage channels in station
  As an admin
  I need to be able to update a channel

  Scenario: Update a channel as admin
    Given I am an admin
    And There is the station "Test"
    And There is a "Test" channel in the station
    When I update the channel with name "New name" and description "Desc"
    Then I should be notified that the channel is updated

  Scenario: Not authorized to update a channel as regular user
    Given I am a user
    And There is the station "Test"
    And There is a "Test" channel in the station
    When I update the channel with name "New name" and description "Desc"
    Then I should be notified that I'm not authorized for operation "channel:update"
