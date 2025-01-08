# HarpIA Survey

HarpIA Survey is a tool that implements the execution and evaluation of
large language models (LLMs) by human evaluators using Moodle.

## License

Following Moodle's license,
HarpIA Survey is provided freely as open source software,
under version 3 of the GNU General Public License.

## Pre-requisites

A web server with Docker.

## Installation — for production and test environments

Clone or download this repository, and open a terminal in its root
directory (which contain this README file). Follow the steps below:

1. Install Docker.
2. Build the image:

```shell
docker build -t harpia-survey:1.0 -f containers/prod/Dockerfile .
```

3. Create an empty directory where data will be stored,
   and take note of its location.<br>
   **IMPORTANT**: In the next steps, whenever the data directory is used,
   if it is a descendant of the repository root, relative paths **must**
   be written starting with `./` (e.g. instead of `data/somewhere`, write
   `./data/somewhere`).

4. Define the the HarpIA Survey home page address, which is the URL that
   users will access. The address has a protocol (`http://` or
   `https://`), a subdomain/domain or IP, a port (if not the default for
   the protocol) and path (optional, empty by default):

   - in a local environment available on a single
     computer, this address will look like `http://localhost:8080/`
     (the port can be changed);
   - in a server accessible from other computers
     (via the internet or a local network), the address may look like:
     - `https://yourwebsite.example.com/`;
     - `https://yourwebsite.example.com:8080/`;
     - `http://192.168.99.99:8080/`.

5. Run initial Moodle setup
   (**replace `<DATADIR>` with the directory defined in step 3**, and
   **replace `<ADDRESS>` with the address explained in step 4**):

   ```shell
   docker run --rm -it --name harpia-survey -v '<DATADIR>':/harpia/data harpia-survey:1.0 php /harpia/src/harpia_setup.php --admin-user='harpia_admin' --www-root='<ADDRESS>'
   ```

   When prompted, type the password of the first account that will
   be created (the administrator), whose username is `harpia_admin` as defined
   in the command above.
   Then, the initial Moodle set up will be executed, and it may take several minutes.

6. Start the server container
   (**replace <PORT> with the desired port**, the same used in step 4, and
   **replace `<DATADIR>` with the directory defined in step 3**):

   ```shell
   docker run --rm -d --name harpia-survey  -p '<PORT>':80 -v '<DATADIR>':/harpia/data -v '<DATADIR>'/config.php:/var/www/html/config.php --add-host=harpia-model-gateway:host-gateway harpia-survey:1.0
   ```

   Note: the argument `--add-host=harpia-model-gateway:host-gateway` makes the host's
   `localhost` available as `harpia-model-gateway`.

   Temporarily, only during the installation until everything is working, `-d` can be removed
   to keep the container in the foreground (which allows killing it with <kbd>Ctrl</kbd>+<kbd>C</kbd>).

7. Open in your web browser the address defined in step 4.

   - Log in using the credentials chosen in step 5.
   - Fill in the form to complete the creation of the administrator's account and
     click **Update profile**.

8. Make sure the [HarpIA Model Gateway container](../../../HarpIA_Model_Gateway)
   is running and that the communication between the
   containers is not blocked by firewalls or system
   settings.

   When both containers are running, the following command can
   quickly show if the HarpIA Survey container can access the model
   gateway (replace the values accordingly). If it works, the
   model's output will be displayed.

   ```shell
   docker exec harpia-survey curl -X POST http://harpia-model-gateway:42774/send -H "Content-Type: application/json" -d '{"query": "this is a test", "answer_provider": "ECHO"}'
   ```


9. With _Edit Mode_ enabled,
   go to _Site administration_ > _Plugins_ > _Local plugins_ > _HarpIA AJAX_,
   and fill in the address of the HarpIA Model Gateway server
   (if the name in step 6 was kept and the default port was used for the gateway,
   the address is `http://harpia-model-gateway:42774`).

10. Create user accounts, courses and activities. (TO DO: add detailed steps)

#### Updating

Stop the container and run the steps 2 and 6 above.

## Installation — for production and test environments

(TO DO)
