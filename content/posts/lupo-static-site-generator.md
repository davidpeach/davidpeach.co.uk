---
title: Lupo static site generator
authors:
  - name: David Peach
    url: https://davidpeach.me
    avatarUrl: >-
      https://secure.gravatar.com/avatar/4d7faf5eee1f055a85788c44936b8995eaab6dfb004e7854ec747ccb272e91ee?s=96&d=mm&r=g
date: 2023-08-30T11:32:00.000Z
metadata:
  categories:
    - Programming
  tags:
    - Lupo
  uuid: 11ty/import::wordpress::https://davidpeach.co.uk/?p=50724
  type: wordpress
  url: https://davidpeach.me/2023/08/30/lupo-static-site-generator/
tags:
  - programming
---
## What is Lupo?

Lupo is a simple static site generator, written in Bash.

I built it for myself to publish to a simple website of my own directly from the command line.

It was inspired by Rob Muhlestein and his approach to the Zettelkasten method.

## Installation

Running through the following set of commands will install the lupo bash script to the following location on your system: `$HOME/.local/bin/lupo`

If you add the `$HOME/.local/bin` directory to your `$PATH`, then you can execute the `lupo` command from anywhere.

I chosen that directory as it seems to be a pretty standard location for user-specific scripts to live.

Bash```
git clone https://github.com/davidpeach/lupo
cd ./lupo
./install
cd ..
rm -rf ./lupo
```

## Anatomy of a Lupo website

The structure of a newly-initialized Lupo website project is as follows:

Bash```
.
./html/
./src/
./src/style.css
./templates/
./tmp/
```

All of your website source code lives within the `./src` directory. This is where you structure your website however you want it to be structured in the final html.

You can write your pages / posts in markdown and lupo will convert them when building.

When building it into the final html, lupo will copy the structure of your `./src` directory into your `./html` directory, converting any markdown files (any files ending in `.md`) into html files.

Any JavaScript or CSS files are left alone and copied over in the same directory relative to the `./html` root.

## Starting a lupo website

Create a directory that you want to be your website project, and initialize it as a Lupo project:

Bash```
mkdir ./my website
cd ./my-website
lupo init
```

The `init` command will create the required directories, including a file located at `$HOME/.config/lupo/config`.

You don’t need to worry about the config file just yet.

Create your homepage file and add some text to it:

Bash```
touch ./src/index.md
echo "Hello World" > ./src/index.md
```

Now just run the build command to generate the final html:

Bash```
lupo build
```

You should now have two files in your `./html` directory: an `index.html` file and a `style.css` file.

The `index.html` was converted from your `./src/index.md` file and moved into the root of the `./html` directory. The `style.css` file was copied over verbatim to the html directory.

## Viewing your site locally

Lupo doesn’t currently have a way to launch a local webserver, but you could open a browser and point the address bar to the root of your project `./html` folder.

I use an nginx docker image to preview my site locally, and will build in this functionality into lupo soon.

## Page metadata

Each markdown page that you create, can have an option metadata section at the top of the page. This is known as “frontmatter”. Here is an example you could add to the top of your `./src/index.md` file:

Markdown```
---
title: My Super Homepage
---

Here is the normal page content
```

That will set the page’s title to “My Super Homepage”. This will also make the `%title%` variable available in your template files. (More on templates further down the page)

If you re-run the `lupo build` command, and look again at your homepage, you should now see an `<h1>` tag withyou title inside.

## The Index page

You can generate an index of all of your pages with the `index` command:

Bash```
lupo index

lupo build
```

Once you’ve built the website after running `index`, you will see a file at `./html/index/index.html`. This is a simple index / archive of all of the pages on your website.

For pages with a title set in their metadata block, that title will be used in the index listing. For any pages without a title set, the uri to the page will be used instead.

@todo ADD SEARCH to source and add to docs here.

## Tag index pages

Within your page metadata block, you can also define a list of “tags” like so:

Markdown```
---
title: My Super Page
tags:
    - tagone
    - tagtwo
    - anotherone
---

The page content.
```

When you run the `lupo index` command, it will also go through all of your pages and use the tags to generate “tag index pages”.

These are located at the following location/uri: `./html/tags/tagname/index.html`.

These tag index pages will list all pages that contain that index’s tag.

## Customizing your website

Lupo is very basic and doesn’t offer that much in the way of customization. And that is intentional – I built it as a simple tool for me and just wanted to share it with anyone else that may be interested.

That being said, there are currently two template files within the `./templates` directory:

Bash```
./templates/default.template.html
./templates/tags.template.html
```

`tags.template.html` is used when generating the “tag index” pages and the main “index” page.

`default.template.html` is used for all other pages.

_I am planning to add some flexibility to this in the near future and will update this page when added._

You are free to customize the templates as you want. And of course you can go wild with your CSS.

_I’m also considering adding an opt-in css compile step to enable the use of something like `sass`._

## New post helper

To help with the boilerplate of add a new “post”, I add the following command:

Bash```
lupo post
```

When ran, it will ask you for a title. Once answered, it will generate the post src file and pre-fill the metadata block with that title and the current date and timestamp.

The post will be created at the following location:

Bash```
./src/{year}/{month}/{date}/{timestamp}/{url-friendly-title}

# For example:
./src/2023/08/30/1693385086/lupo-static-site-generator/index.html
```

## Page edit helper

_At present, this requires you to have `fzf` installed. I am looking to try and replace that dependancy with the `find` command._

To help find a page you want to edit, you can run the following command:

Bash```
lupo edit
```

This will open up a fuzzy search finder where you can type to search for the page you want to edit.

The results will narrow down as you type.

When you press enter, it will attmept to open that source page in your system’s default editor. Defined in your `$EDITOR` environment variable.

## Automatic rebuild on save

_This requires you to have inotifywait installed._

Sometimes you will be working on a longer-form page or post, and want to refresh the browser to see your changes as you write it.

It quickly becomes tedious to have to keep running `lupo build` to see those changes.

So running the following command will “watch” you `./src` directory for any changes, and rebuild any file that is altered in any way. It will only rebuild that single file; not the entire project.

## Deploying to a server

_This requires you to have `rsync` installed._

This assumes that you have a server setup and ready to host a static html website.

I covered how I set up my own server in [This Terraform post](https://davidpeach.me/2023/08/29/setting-up-a-digital-ocean-droplet-for-a-lupo-website-with-terraform/) and [This Ansible post](https://davidpeach.me/2023/08/29/using-ansible-to-prepare-a-digital-ocean-droplet-to-host-a-static-website/).

All that lupo needs to be able to deploy your site, is for you to add the required settings in your config file at `$HOME/.config/lupo/config`

-   **remote\_user** – This is the user who owns the directory where the html files will be sent to.
-   **ssh\_identity\_key** – This is the path to the private key file on your computer that pairs with the public key on your remote server.
-   **domain\_name** – The domain name pointing to your server.
-   **remote\_directory** – The full path to the directory where your html files are served from on your server.

For example:

Bash```
remote_user: david
ssh_identity_key: ~/.ssh/id_rsa
domain_name: example.com
remote_directory: /var/www/example.com
```

Then run the following command:

Bash```
lupo push
```

With any luck you should see the feedback for the files pushed to your remote server.

Assuming you have set up you domain name to point to your server correctly, you should be able to visit you website in a browser and see your newly-deployed website.

## Going live

_This is an experimental feature_

If you’ve got the `lupo watch` and `lupo push` commands working, then the live command should also work:

Bash```
lupo live
```

This will watch your project for changes, and recompile each updated page and push it to your server as it is saved.

The feedback is a bit verbose currently and the logic needs making a bit smarter. But it does currently work in its initial form.