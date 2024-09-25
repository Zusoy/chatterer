Feature: Create Forum
  In order to manage forums in station
  As an admin
  I need to be able to create new forum

  Scenario: Create new forum as admin
    Given I am an admin
    And There is the station "Test"
    When I create a new forum for the station with
      | name  |
      | Forum |
    Then I should be notified that the forum is created

  Scenario: Not authorized to create forum as regular user
    Given I am a user
    And There is the station "Test"
    When I create a new forum for the station with
      | name  |
      | Forum |
    Then I should be notified that I'm not authorized for operation "forum:create"

  Scenario: Fail to create forum in non existing station
    Given I am an admin
    When I create a forum "Random" for non existing station
    Then I should be notified that the station does not exists
