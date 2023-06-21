Feature: Create message
  In order to chat with other members
  As a regular user or as an admin
  I need to be able to post message in a channel

  Scenario: Post message in a channel
    Given I am a user
    And There is the station "Company"
    And I am member of the station
    And There is a "Meetings" channel in the station
    When I post the message "Hello World" in the channel
    Then I should be notified that the message is created

  Scenario: Not authorized to post message in channel without being member of station
    Given I am a user
    And There is the station "Company"
    But I am not member of the station
    And There is a "Meetings" channel in the station
    When I post the message "Hello World" in the channel
    Then I should be notified that I'm not authorized for operation "message:create"
