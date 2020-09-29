<header>
  <h1 align="center">Slack Block Kit for PHP</h1>
  <p align="center">By Jeremy Lindblom (<a href="https://twitter.com/jeremeamia">@jeremeamia</a>)</p>
</header>

<p align="center">
  <img src="https://repository-images.githubusercontent.com/220265593/f2249880-0872-11ea-9eba-fb8f1b1c5ffb" alt="Slack Block Kit for PHP" width="50%">
</p>

<p align="center">
  <a href="http://php.net/">
    <img src="https://img.shields.io/badge/code-php7-8892bf.svg" alt="Coded in PHP 7">
  </a>
  <a href="https://packagist.org/packages/jeremeamia/slack-block-kit">
    <img src="https://img.shields.io/packagist/v/jeremeamia/slack-block-kit.svg" alt="Packagist Version">
  </a>
  <a href="https://github.com/jeremeamia/slack-block-kit/actions">
    <img src="https://img.shields.io/github/workflow/status/jeremeamia/slack-block-kit/PHP%20Composer.svg" alt="Build Status">
  </a>
</p>

---

## Introduction

From Slack's [Block Kit documentation](https://api.slack.com/block-kit):

> **Block Kit** is a UI framework for Slack apps that offers a balance of control and flexibility when building
> experiences in messages and other _surfaces_.
> 
> Customize the order and appearance of information and guide users through your app's capabilities by composing,
> updating, sequencing, and stacking _blocks_ — reusable components that work almost everywhere in Slack.

This library provides an OOP interface in PHP for composing messages using Slack Block Kit.

## Block Kit Concepts

This library helps you build Slack messages programmatically and dynamically in your code, but you need to know how they
work generally first. The library does try to prevent you from doing things you are not permitted to do in Block Kit,
but it does not validate or guard against every single rule.

You may want to review the following concepts in the Slack documentation:

- [Surfaces](https://api.slack.com/surfaces) – There are 3 types: Message, Modal, and App Home
- [Blocks](https://api.slack.com/reference/block-kit/blocks) – Includes _section_, _context_, _actions_, and more
- [Interactive Components](https://api.slack.com/reference/block-kit/interactive-components) – We call these "Inputs" in this library
- [Composition Objects](https://api.slack.com/reference/block-kit/composition-objects) – We call these "Partials" ion the library

In general, we refer to all of the different things in Block Kit collectively as "elements".  

## Installation

Install easily via Composer:

```bash
composer require jeremeamia/slack-block-kit
```

Then include the Composer-generated autoloader in your project's initialization code.

_Note: This library is built for PHP 7.2+._

## Basic Usage

This library supports an intuitive syntax for composing Slack messages. The `Slack` class acts as a façade to the
entire library, and let's you start new messages.

```php
<?php

use Jeremeamia\Slack\BlockKit\Slack;

// ...

$msg = Slack::newMessage();
$msg->text('Don\'t you just love XKCD?');
$msg->divider();
$msg->newImage()
    ->title('Team Chat')
    ->url('https://imgs.xkcd.com/comics/team_chat.png')
    ->altText('Comic about the stubbornness of some people switching chat clients');

// Messages can be converted to JSON using PHP's regular `json_encode` function.
$json = json_encode($msg);
```

### Renderers

This library comes with 3 message/surface renderers out of the box.

All the renderers can be accessed from the `Slack` façade class, as well.

All the examples below will show the message above being rendered.

#### JSON

This renderer outputs JSON and is similar to just `json_encode`-ing the message. However, it will use the
pretty-print option.

```php
echo Slack::newRenderer()->forJson()->render($msg);
```

##### Output

```
{
    "response_type": "ephemeral",
    "blocks": [
        {
            "type": "section",
            "text": {
                "type": "mrkdwn",
                "text": "Don't you just love XKCD?"
            }
        },
        {
            "type": "divider"
        },
        {
            "type": "image",
            "title": {
                "type": "plain_text",
                "text": "Team Chat",
                "emoji": true
            },
            "image_url": "https:\/\/imgs.xkcd.com\/comics\/team_chat.png",
            "alt_text": "Comic about the stubbornness of some people switching chat clients"
        }
    ]
}
```

### Block Kit Builder

Slack provides an [interactive Block Kit Builder](https://api.slack.com/tools/block-kit-builder) for composing/testing
messages. This is a great way to play around with and learn the Block Kit format.

The `KitBuilder` renderer allows you to render your message/surface as a Block Kit Builder link, so you can preview your
message in the browser as Slack would render it via their interactive tool.

```php
echo Slack::newRenderer()->forKitBuilder()->render($msg);
```

##### Output

```
https://api.slack.com/tools/block-kit-builder?mode=message&blocks=%5B%7B%22type%22%3A%22section%22%2C%22text%22%3A%7B%22type%22%3A%22mrkdwn%22%2C%22text%22%3A%22Don%27t%20you%20just%20love%20XKCD%3F%22%7D%7D%2C%7B%22type%22%3A%22divider%22%7D%2C%7B%22type%22%3A%22image%22%2C%22title%22%3A%7B%22type%22%3A%22plain_text%22%2C%22text%22%3A%22Team%20Chat%22%2C%22emoji%22%3Atrue%7D%2C%22image_url%22%3A%22https%3A%2F%2Fimgs.xkcd.com%2Fcomics%2Fteam_chat.png%22%2C%22alt_text%22%3A%22Comic%20about%20the%20stubbornness%20of%20some%20people%20switching%20chat%20clients%22%7D%5D
```

And here's the [actual Block Kit Builder link](https://api.slack.com/tools/block-kit-builder?mode=message&blocks=%5B%7B%22type%22%3A%22section%22%2C%22text%22%3A%7B%22type%22%3A%22mrkdwn%22%2C%22text%22%3A%22Don%27t%20you%20just%20love%20XKCD%3F%22%7D%7D%2C%7B%22type%22%3A%22divider%22%7D%2C%7B%22type%22%3A%22image%22%2C%22title%22%3A%7B%22type%22%3A%22plain_text%22%2C%22text%22%3A%22Team%20Chat%22%2C%22emoji%22%3Atrue%7D%2C%22image_url%22%3A%22https%3A%2F%2Fimgs.xkcd.com%2Fcomics%2Fteam_chat.png%22%2C%22alt_text%22%3A%22Comic%20about%20the%20stubbornness%20of%20some%20people%20switching%20chat%20clients%22%7D%5D). 

It will show up in the Block Kit Builder looking something like this:

![Screenshot of rendered message in Block Kit Builder](block-kit-screenshot.png)

#### CLI

Sometimes previewing the content of a message in the Terminal/CLI is useful, but the JSON representation can be
difficult to read. The CLI renderer will render to a more CLI-friendly format.

```php
echo Slack::newRenderer()->forCli()->render($msg);
```

##### Output

```
(•) Only visible to you
message:
  blocks:
    section:
      text:
        mrkdwn: "Don't you just love XKCD?"
    ----------------------------------------
    image:
      title:
        plain_text: "Team Chat"
      image_url: https://imgs.xkcd.com/comics/team_chat.png
      alt_text: Comic about the stubbornness of some people switching chat clients
```

## Supported Elements

The following are supported elements from the Block Kit documentation:

| **Type** | **Element**        | **Supported?** |
|----------|--------------------|----------------|
| Surface  | App Home           | ✅             |
| Surface  | Message            | ✅             |
| Surface  | Model              | ✅             |
| Block    | Actions            | ✅             |
| Block    | Checkboxes         | ✅             |
| Block    | Context            | ✅             |
| Block    | Divider            | ✅             |
| Block    | File               | ❌             |
| Block    | Image              | ✅             |
| Block    | Input              | ✅             |
| Block    | Section            | ✅             |
| Input    | Button             | ✅️             |
| Input    | Date Picker        | ✅             |
| Input    | Multi-select Menus | ✅✅✅✅✅    |
| Input    | Overflow Menu      | ✅             |
| Input    | Plain Text Input   | ✅             |
| Input    | Radio Buttons      | ✅             |
| Input    | Select Menus       | ✅✅✅✅✅    |
| Partial  | Confirm Dialog     | ✅             |
| Partial  | Mrkdwn Text        | ✅             |
| Partial  | Fields             | ✅             |
| Partial  | Option             | ✅             |
| Partial  | Option Group       | ✅             |
| Partial  | Plain Text         | ✅             |

### Virtual Elements

The following are virtual/custom elements composed of one or more blocks:

* `TwoColumnTable` - Uses Sections with Fields to create a two-column table with an optional header.

## Class Structure

### Surfaces and Renderers

The `Slack` façade provides ways to create _surfaces_ and _renderers_. A renderer is used to render a surface (and its
blocks) into a displayable format.

![UML diagram for surfaces and renderers](https://yuml.me/5d2be60a.png)

<details>
<summary>See the YUML</summary>
<pre>
[Slack]-creates>[Renderer]
[Slack]-creates>[Surface]
[Surface]^[Message]
[Surface]^[Modal]
[Surface]^[AppHome]
[Element]^[Surface]
[Element]^[Block]
[Renderer]^[Json]
[Renderer]^[KitBuilder]
[Renderer]^[Cli]
[Surface]<>->[Block]
</pre>
</details>

### Blocks and Other Elements

_Blocks_ are the primary element of the Block Kit. Blocks contain other elements that are grouped into _inputs_
(interactive elements) and _partials_ (repeatable element parts that are not uniquely identifiable).

![UML diagram for blocks](https://yuml.me/6bf6925a.png)

<details>
<summary>See the YUML</summary>
<pre>
[Element]^[Surface]
[Element]^[Block]
[Element]^[Input]
[Element]^[Partial]
[Surface]<>->[Block]
[Block]<>->[Input]
[Block]<>->[Partial]
[Input]-[note: examples:;Button;DatePicker{bg:cornsilk}]
[Partial]-[note: examples:;Text;Fields{bg:cornsilk}]
[Block]-[note: examples:;Section;Actions{bg:cornsilk}]
</pre>
</details>

### Contributions

Contributions welcome to support new elements, write tests, setup github actions, etc. See the Project tab.

When implementing elements, to fit within the existing DSL, consider these points:

- To set instantiated sub-element objects, provide a `set`-prefixed setter (e.g., `setText(Text $text): self`).
    - Should return `self` to support chaining.
    - Should set the parent (e.g., `setParent()`) of the sub-element to `$this`.
- To set simple sub-element objects, provide a simple setter method (e.g., `title(string $title): self`).
    - Should be in addition to the `set`-prefixed setter.
    - Should be named after the property being set.
    - Should return `self` to support chaining.
    - Should have a maximum of 2 parameters.
    - Should call the regular setter (e.g., `return $this->setText(new PlainText($title));`).
- To set other non-element properties, provide a simple setter method (e.g., `url(string $url): self`).
    - Should be named after the property being set.
    - Should return `self` to support chaining.
- To create new sub-elements attached to the current one, provide a `new`-prefixed factory method (e.g., `newImage(): Image`).
    - Should return an instance of the sub-element.
    - Should set the parent (e.g., `setParent()`) of the sub-element to `$this` before returning.
    - Should support a `$blockId` parameter if it's a Block or an `$actionId` parameter if it's an Input element.
- All element types should be defined in the `Type` class and registered in relevant constant lists to be appropriately validated.
- If you implement a custom constructor for an element, make sure all the parameters are optional.
