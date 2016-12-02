Required Records
======================

This [bolt.cm](https://bolt.cm/) extension lets you define required records. 
It's pretty useful when your application depends on some records in a resource 
contenttype.

### Installation
1. Login to your Bolt installation
2. Go to "Extend" or "Extras > Extend"
3. Type `required-records` into the input field
4. Click on the extension name
5. Click on "Browse Versions"
6. Click on "Install This Version" on the latest stable version

### Configuration

This extension has no own config file. You can configure everything in your `contenttypes.yml`.

Here is an example with a simple resource ContentType for social media:

```
social:
    name: Social Media
    singular_name: Social Media
    fields:
        title:
            type: text
            class: large
        slug:
            type: slug
            uses: title
        name:
            type: text
    required:
        - slug: twitter
          title: Twitter
        - slug: github
          title: Github
    default_status: published
    show_on_dashboard: false
    searchable: false
    viewless: true
```

As you can see, we just added the `required` section to the ContentType 
where you can define the records you need.

#### Optional Fields

In some cases, you want to set a field value for a record when it gets created 
but also want to allow the editor to override this value. 

This can the archived with optional fields. Here is an example:

```
    required:
        - slug: twitter
          title: Twitter
          "url|o": https://twitter.com/PhillippOh
        - slug: github
          title: Github
          "url|o": https://github.com/PhillippOhlandt
```

As you can see, we just added `|o` to the field name. Now the `url` field value 
can be changed any time because this extension only checks for records with the 
exact `slug` and `title` field. 

This setting is individual to each defined record, not to the whole ContentType.
For example, you could define a facebook record where the `url` field is not optional.

**Note:** Because of the `|` character in optional field names, the field name has to
be in double quotes. Otherwise the YAML parser will throw an error.

### Usage

Your required records won't be automaticly created. All you need to do is to hit one 
button or run one nut command though.

#### Via Admin Interface
In your backend, go to `Extras` => `Required Records`.
There you'll see an overview of all your required records.
Missing records are marked with a red background.

To create all missing records, just hit the `Add Records` button.

#### Via Nut Command
This extension is great for automatic deployments because you can 
create all missing records via a single nut command.

###### Commands

| Command                         | Description                 |
|---------------------------------|-----------------------------|
| app/nut required-records:show   | Shows all required records  |
| app/nut required-records:check  | Lists all missing records   |
| app/nut required-records:create | Creates all missing records |

---

### License

This Bolt extension is open-sourced software 
licensed under the [MIT license](http://opensource.org/licenses/MIT)
