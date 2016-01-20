Required Records for Bolt
======================

This [bolt.cm](https://bolt.cm/) extension lets you define required records. 
It's pretty useful when your application depends on some records in a resource contenttype.

### Installation
1. Login to your Bolt installation
2. Go to "View/Install Extensions" (Hover over "Extras" menu item)
3. Type `required-records` into the input field
4. Click on the extension name
5. Click on "Browse Versions"
6. Click on "Install This Version" on the latest stable version

### Configuration
This extension has no own config file. You can configure everything in your `contenttypes.yml`.

Lets do an example with a simple resource contenttype for social media:

```
social:
    name: Social Media
    singular_name: Social Media
    fields:
        title:
            type: text
            class: large
            group: content
        slug:
            type: slug
            uses: title
        username:
            type: html
            height: 300px
    required:
        - slug: twitter
          title: Twitter
        - slug: github
          title: Github
    default_status: published
    sort: -datepublish
```

As you can see, we just added the `required` section to the contenttype where you can define the records you need.

###### Note:
Don't define the real content of a record, otherwise this extension would create a new record after you changed the content.
It's better to just define the `slug` and maybe the `title` as well.

### Usage
Your required records won't be automaticly created but you just have to hit one button or run one nut command.

#### Via Admin Interface
In your backend, go to `Extras` => `Required Records`.
There you'll see an overview of all your required records.

If some records are missing, you'll see a list of them as well. Just hit the `Add Records` button and they will be created for you.

#### Via Nut Command
This extension is great for automatic deployments because you can create all missing records via a single nut command.

###### Commands

| Command                         | Description                 |
|---------------------------------|-----------------------------|
| app/nut required-records:show   | Shows all required records  |
| app/nut required-records:check  | Lists all missing records   |
| app/nut required-records:create | Creates all missing records |

---

### License

This Bolt extension is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)