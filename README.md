# Slack Block Kit for PHP

OOP interface for writing Slack Block Kit messages

## Class Structure

### Surfaces and Renderers

The `Slack` façade provides ways to create _surfaces_ and _renderers_.

* _Surface_ – Represents in Slack where _blocks_ can be displayed. The primary type of surface is a Slack message.
* _Renderer_ – Renders a surface object into a displayable format.

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

_Blocks_ are the primary element of the Block Kit. Blocks contain other sub-elements that are grouped into
_inputs_ and _partials_.

* _Blocks_ – High-level elements of a surface that contain text, images, inputs, etc., and are defined by Slack.
* _Inputs_ – Interactive elements (e.g., buttons, datepickers) that are sub-elements of blocks.
* _Partials_ – Sub-elements of blocks and inputs that do not have their own identity.

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
