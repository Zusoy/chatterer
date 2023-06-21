Feature: Delete message
  In order to manage channel messages and my messages
  As a regular user or as an admin
  I need to be able to delete message in a channel

  Scenario: Delete a message as author
    Given I am a user
    And There is the station "Company"
    And I am member of the station
    And There is a "Meetings" channel in the station
    And I have posted the message "Hello World" in the channel
    When I delete the message
    Then I should be notified that the message is deleted

  Scenario: Delete a message from another member as admin
    Given I am an admin
    And There is the station "Company"
    And I am member of the station
    And There is a "Meetings" channel in the station
    And There is multiple members in the station
    And One member of the station have posted the message "Some secrets" in the channel
    When I delete the message
    Then I should be notified that the message is deleted

  Scenario: Not authorized to delete message without being the author
    Given I am a user
    And There is the station "Company"
    And I am member of the station
    And There is a "Meetings" channel in the station
    And There is multiple members in the station
    And One member of the station have posted the message "Hello World" in the channel
    When I delete the message
    Then I should be notified that I'm not authorized for operation "message:delete"
