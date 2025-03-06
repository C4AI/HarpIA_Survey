# HarpIA Survey

HarpIA Survey is a tool that implements the execution and evaluation of
large language models (LLMs) by human evaluators using Moodle.


HarpIA Survey is comprised of two Moodle plugins:
- [HarpIA Ajax](../../../moodle-local_harpiaajax/), a local plugin
  that implements an API which allows a Moodle user to send requests
  to a language model as part of an activity;
- [HarpIA Interaction](../../../moodle-datafield_harpiainteraction),
  a plugin for the Database activity that provides an interactive field,
  using the first plugin to communicate with a language model.

In order to install the plugins on a Moodle instance,
follow the documentation in the repositories linked above. 

Alternatively, the Docker images in this repository contain a full Moodle
installation:

- [Development environments](../../wiki/Installation-instructions-(development-environments))
- [Test and production environments](../../wiki/Installation-instructions-(production-and-test-environments))

## License

Following Moodle's license,
HarpIA Survey is provided freely as open source software,
under version 3 of the GNU General Public License.

