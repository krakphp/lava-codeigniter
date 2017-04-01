============================
Lava CodeIgniter Integration
============================

You can integrate the Lava framework with CI by embedding an app inside of the CI
framework.

The idea for this integration came from a legacy site I've managed before where we couldn't remove the old CI framework, but we needed to add new features that the Lava Framework could solve. So, this allows a nice bridge from an older system to a new one.

Installation
------------

Install with composer at ``krak/lava-codeigniter``

Usage
-----

To have an app that you want to embed inside of the CI framework, you'll need to do a few things.

1. Create a controller to handle the Lava Routes named like `application/controllers/lava.php`
2. Create your lava app inside of the controller method.

.. code-block:: php

    <?php

    use Krak\Lava;
    use Krak\LavaCodeIgniter\CodeIgniterPackage;

    class Lava extends CI_Controller
    {
        public function index() {
            $app = new Lava\App();
            $app->with(CodeIgniterPackage($this));

            $app->routes(function($r) {
                $r->get('/home', function() {
                    return ['welcome', ['name' => 'RJ']];
                });
                $r->get('/exception', function() {
                    throw new \InvalidArgumentException("Whoa!!");
                });
            });

            $app->serve();
        }
    }

3. Register the default route to point to your mw/index action. All undefined routes will lead to it now.

.. code-block:: php

    <?php

    $route['404_override'] = 'lava';

Make sure to add the CodeIgniter package last or at least later on in the packages.

API
---

These are all relative to the ``Krak\LavaCodeIgniter`` namespace.

ciHtmlRenderError()
~~~~~~~~~~~~~~~~~~~

An exception handler that will use the CI ``Exceptions`` class to display the exception.

ciViewMarshalResponse()
~~~~~~~~~~~~~~~~~~~~~~~

Allows actions to return two-tuples of ``[string, array]`` which represent the view path and the data to load into the view. This internally uses the ``$this->load->view`` method in the CI framework.

CodeIgniterPackage
~~~~~~~~~~~~~~~~~~

Registers the CI emitter and adds the ci funcs into the stack.

:renderErrorStack:
    pushes ``ciHtml``
:marshalResponseStack:
    pushes ``ciView``
