Haanga2
=======

Introduction
------------

Haanga is an open source template engine inspired by Django's templates. It was primarily designed and programmed for [Menéame](http://meneame.net/) usage, but then it was released as an open source project.

Haanga2 is the rewrite of the Haanga project to accomplish several goal:

1. Extend the language and borrow some cool features of [Twig](http://twig.sensiolabs.org/)
2. Provide a `cli` tool that will allow us to compile our templates offline.
3. Add a simple way to generate extensions. It is done by using `crodas/Artifex`. All extensions should generate code.

How it works
-------------

The Haanga2 is a `compiler`, it will take an input like this:

```django
<h1>Hi {{user}}</h1>

{% if age < 18 %}
	<span class="error">You should not be here.</span>
{% endif %}
```

And will generate the equivalente code in PHP, something like this:

```php
<?php

echo "<h1>Hi ${user}</h1>\n";
if ($age < 18) {
	echo "<span class=\"error\">You should not be here.</span>";
}
```

Haanga2's task is to convert your nice template into an ugly but efficient way of rendering your information. As you can see, at runtime (when the template is executed) Haanga2 is not used at all.

Some concepts
-------------

* Haanga2 is only a compiler, the generated code is prepared to run without any dependencies.
* The templates supports inheritance, exactly the same way as Django does.
* Extension and filters generates code.
