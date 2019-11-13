# Slack Block Kit for PHP

## Introduction

From Slack's [Block Kit documentation](https://api.slack.com/block-kit):

> **Block Kit** is a UI framework for Slack apps that offers a balance of control and flexibility when building
> experiences in messages and other _surfaces_.
> 
> Customize the order and appearance of information and guide users through your app's capabilities by composing,
> updating, sequencing, and stacking _blocks_ — reusable components that work almost everywhere in Slack.

This library provides an OOP interface in PHP for composing messages using Slack Block Kit.

## Block Kit Concepts

- [Surfaces](https://api.slack.com/surfaces) – There are 3 types: Message, Modal, and App Home
- [Blocks](https://api.slack.com/reference/block-kit/blocks) – Includes _section_, _context_, _actions_, and more
- [Interactive Components](https://api.slack.com/reference/block-kit/interactive-components) – We call these "Inputs" in this library
- [Composition Objects](https://api.slack.com/reference/block-kit/composition-objects) – We call these "Partials" ion the library

### Block Kit Builder

Slack provides an [interactive Block Kit Builder](https://api.slack.com/tools/block-kit-builder) for composing/testing.
This is a great way to play around with and learn the JSON formatting required to build messages with Block Kit.

This library helps you build them programmatically and dynamically in your code, but you need to know how they work 
generally first. The library does try to prevent you from doing things you are not permitted to do in Block Kit, but it
does not validate or guard against every single rule. It also provides `Renderers\KitBuilder`, which will render you
message/surface as a Block Kit Builder link, so you can preview your message as Slack would render it.  

## Basic Usage

```php
<?php
// ...
use Jeremeamia\Slack\BlockKit\Slack;
// ...

$msg = Slack::newMessage();
$msg->newSection('b1')->mrkdwnText('Something _bad_ happened!');
$msg->divider('b2');
$msg->newImage('b3')
    ->title('Uh, oh!')
    ->url('https://i.imgflip.com/3dezi8.jpg')
    ->altText('A train that has come off of the railroad tracks');

$json = json_encode($msg);
```

## Supported Elements

| **Type**    | **Element**       | **Supported?** |
|-------------|-------------------|----------------|
| Surface     | App Home          | Yes            |
| Surface     | Message           | Yes            |
| Surface     | Model             | Yes            |
| Block       | Actions           | Yes            |
| Block       | Context           | Yes            |
| Block       | Divider           | Yes            |
| Block       | File              | No             |
| Block       | Image             | Yes            |
| Block       | Input             | Yes            |
| Block       | Section           | Yes            |
| Interactive | Button            | Partial        |
| Interactive | Date Picker       | Yes            |
| Interactive | Multi-select Menu | No             |
| Interactive | Overflow Menu     | No             |
| Interactive | Radio Buttons     | No             |
| Interactive | Select Menu       | No             |
| Partial     | Confirm Dialog    | Yes            |
| Partial     | Mrkdwn Text       | Yes            |
| Partial     | Option            | No             |
| Partial     | Option Group      | No             |
| Partial     | Plain Text        | Yes            |

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
