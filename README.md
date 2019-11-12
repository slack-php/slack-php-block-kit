# Slack Block Kit for PHP

OOP interface for writing Slack Block Kit messages

## High-Level Class Structure

 ![High-level UML diagram](https://yuml.me/5d2be60a.png)

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
[Surface]<>->[Block]
[Renderer]^[Json]
[Renderer]^[KitBuilder]
[Renderer]^[Cli]
</pre>
</details>

