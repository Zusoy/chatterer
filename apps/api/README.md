# Chatterer API

<!-- TABLE OF CONTENTS -->
<details>
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#built-with">Built with</a>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#authentication">Authentication</a></li>
        <li><a href="#synchronization">Synchronization</a></li>
        <li><a href="#tests">Tests</a></li>
      </ul>
    </li>
  </ol>
</details>

### Built With

The API is built with :

* [![Symfony][Symfony]][Symfony-url]

<!-- GETTING STARTED -->
## Getting Started

The API is made using the [hexagonal architecture](https://fr.wikipedia.org/wiki/Architecture_hexagonale) and the [Domain Driven Development](https://en.wikipedia.org/wiki/Domain-driven_design) (DDD).


### Authentication

The API is using [JWT](https://jwt.io) token to manage authentication through the new Symfony security system and custom authenticator.

### Synchronization

The Synchronization for user messages is made with [Mercure](https://mercure.rocks/) with Server-Sents-Events (SSE).

### Tests

The API is well tested as it's the main source of truth of the whole application.
So, the API has :

#### Specifications tests

Tests only models and some application specifications (like normalizers).
These tests are made with [PHPSpec](https://phpspec.net/en/stable/)

To run those tests :

```
make api-specs
```

#### Integrations tests

Tests all command handlers (messenger).
These tests are made with [Kahlan](https://kahlan.github.io/docs/)

To run those tests :

```
make api-integrations
```

#### Acceptance tests

Tests the whole application process with HTTP requests and JSON schema validation.
These tests are made with [Behat](https://docs.behat.org/en/latest/) using the Gherkin syntax.

To run those tests :

```
make api-acceptance
```


<!-- MARKDOWN LINKS & IMAGES -->
<!-- https://www.markdownguide.org/basic-syntax/#reference-style-links -->
[Symfony]: https://img.shields.io/badge/Symfony-black?style=for-the-badge&logo=symfony&logoColor=white
[Symfony-url]: https://symfony.com/
