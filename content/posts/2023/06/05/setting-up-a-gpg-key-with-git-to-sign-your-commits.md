---
title: Setting up a GPG Key with git to sign your commits
authors:
  - name: David Peach
    url: https://davidpeach.me
    avatarUrl: >-
      https://secure.gravatar.com/avatar/4d7faf5eee1f055a85788c44936b8995eaab6dfb004e7854ec747ccb272e91ee?s=96&d=mm&r=g
date: 2023-06-05T16:40:00.000Z
metadata:
  featuredImage: https://davidpeach.me/wp-content/uploads/2023/06/gnupg-logo.png
  media:
    featuredImage: /assets/gnupg-logo-xuXbmkek0oIP.png
  categories:
    - Programming
  tags:
    - Linux
  uuid: 11ty/import::wordpress::https://davidpeach.co.uk/?p=50778
  type: wordpress
  url: >-
    https://davidpeach.me/2023/06/05/setting-up-a-gpg-key-with-git-to-sign-your-commits/
tags:
  - programming
---
Signing your git commits with GPG is really easy to set up and I’m always surprised by how many developers I meet that don’t do this.

Of course it’s not required to push commits and has no baring on quality of code. But that green verified message next to your commits does feel good.

Essentially there are three parts to this:

1.  Create your GPG key
2.  Tell git to use your GPG key to sign your commits
3.  Upload the public part of your GPG key to Gitlab / Github / etc

## Creating the GPG key if needed

```
gpg --full-generate-key
```

In the interactive guide, I choose:

1.  (1) RSA and RSA (default)
2.  4096 bits long
3.  Does not expire
4.  Fill in Name, Email, Comment and Confirm.
5.  Enter passphrase when prompted.

## Getting the Key ID

This will list all of your keys:

```
gpg --list-secret-keys --keyid-format=long
```

Example of the output:

```
sec   rsa4096/THIS0IS0YOUR0KEY0ID 2020-12-25 [SC]
      KGHJ64GHG6HJGH5J4G6H5465HJGHJGHJG56HJ5GY
uid                 [ultimate] Bob GPG Key<mail@your-domain.co.uk>
```

In that example, the key id that you would need next is “THIS0IS0YOUR0KEY0ID” from the first line, after the forward slash.

## Tell your local git about the signing key

To set the gpg key as the signing key for all of your git projects, run the following global git command:

```
git config --global user.signingkey THIS0IS0YOUR0KEY0ID
```

If you want to do it on a repository by repository basis, you can run it from within each project, and omit the `--global` flag:

```
git config user.signingkey THIS0IS0YOUR0KEY0ID
```

## Signing your commits

You can either set commit signing to true for all projects as the default, or by a repo by repo basis.

```
# global
git config --global commit.gpgsign true

# local
git config commit.gpgsign true
```

If you wanted to, you could even decide to sign commits per each commit, by not setting it as a config setting, but passing a flag on every commit:

```
git commit -S -m "My signed commit message"
```

## Adding your public key to gitlab / github / wherever

Firstly export the public part of your key using your key id. Again, using the example key id from above:

```
# Show your public key in terminal
gpg --armor --export THIS0IS0YOUR0KEY0ID

# Copy straight to your system clipboard using "xclip"
gpg --armor --export THIS0IS0YOUR0KEY0ID | xclip -sel clipboard
```

This will spit out a large key text block begining and ending with comments. Copy all of the text that it gives you and paste it into the gpg textbox in your git forge of choice – gitlab / github / gitea / etc.