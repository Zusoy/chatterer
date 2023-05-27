Feature: Delete Channel
  In order to manage channels
  As an admin
  I need to be able to delete channel

  Scenario: Delete a channel as admin
    Given I am an admin
    And There is the station "Test"
    And There is a "Test" channel in the station
    When I delete the channel
    Then I should be notified that the channel is deleted

  Scenario: Not authorized to delete channel as regular user
    Given I am a user
    And There is the station "Test"
    And There is a "Test" channel in the station
    When I delete the channel
    Then I should be notified that I'm not authorized for operation "channel:delete"

  Scenario: Fail to delete an non existing channel
    Given I am an admin
    When I delete an non existing channel
    Then I should be notified that the channel does not exists
