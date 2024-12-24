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

1. Install Docker.
2. Build the image:

```shell
docker build -t harpia-survey:1.0 -f containers/prod/Dockerfile .
```

3. Create an empty directory where data will be stored,
   and take note of its location.

4. Define the the HarpIA Survey home page address, which is the URL that
   users will access. The address has a protocol (`http://` or
   `https://`), a subdomain/domain or IP, a port (if not the default for
   the protocol) and path (currently, only `/moodle` is supported):

   - in a local environment available on a single
     computer, this address will look like `http://localhost:8080/moodle`
     (the port can be changed);
   - in a server accessible from other computers
     (via the internet or a local network), the address may look like:
     - `https://yourwebsite.example.com/moodle`;
     - `https://yourwebsite.example.com:8080/moodle`;
     - `http://192.168.99.99:8080/moodle`.

5. Run initial Moodle setup
   (**replace `<DATADIR>` with the directory defined in step 3**, and
   **replace `<ADDRESS>` with the address explained in step 4**):

   ```shell
   docker run --rm -it --name harpia-survey -v '<DATADIR>':/harpia/data harpia-survey:1.0 php /harpia/src/harpia_setup.php --admin-user='harpia_admin' --www-root='<ADDRESS>'
   ```

   You will be asked to type the password of the first account that will
   be created (the administrator), whose username is `harpia_admin` as defined
   in the command above.
   Then, the initial Moodle set up will be executed, and it may take several minutes.

6. Start the server container
   (**replace <PORT> with the desired port**, the same used in step 4, and
   **replace `<DATADIR>` with the directory defined in step 3**):

   ```shell
   docker run --rm -it --name harpia-survey  -p '<PORT>':80 -v '<DATADIR>':/harpia/data -v '<DATADIR>'/config.php:/var/www/html/moodle/config.php harpia-survey:1.0
   ```

7. Open in your web browser the address defined in step 4.
   - Log in using the credentials chosen in step 5.
   - Fill in the form to complete the creation of the administrator's account and click **Update profile**.

#### Updating

Stop the container and run the steps 2 and 6 above.

## Installation — for production and test environments

<!-- TODO -->
