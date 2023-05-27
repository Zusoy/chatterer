Feature: Create Channel
  In order to manage channels in station
  As an admin
  I need to be able to create new channel

  Scenario: Create a new channel as admin
    Given I am an admin
    And There is the station "Test"
    When I create a channel "Random" for the station
    Then I should be notified that the channel is created

  Scenario: Not authorized to create channel as regular user
    Given I am a user
    And There is the station "Test"
    When I create a channel "Random" for the station
    Then I should be notified that I'm not authorized for operation "channel:create"

  Scenario: Fail to create channel in non existing station
    Given I am an admin
    When I create a channel "Random" for non existing station
    Then I should be notified that the station does not exists
