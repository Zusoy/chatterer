Feature: Join Channel
  In order to talk with other members
  As a regular user
  I need to be able to join channel

  Scenario: Join a channel
    Given I am a user
    And There is the station "Company"
    And I am member of the station
    And There is a "Meetings" channel in the station
    When I join the channel
    Then I should be notified that I joined the channel

  Scenario: Not authorized to join channel without being member of the station
    Given I am a user
    And There is the station "Company"
    But I am not member of the station
    And There is a "Meetings" channel in the station
    When I join the channel
    Then I should be notified that I'm not authorized for operation "channel:join"
