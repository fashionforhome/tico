# TiCo Cookbook

This cookook configures the TiCo app.

## Requirements

### Platforms

* Ubuntu

### Chef

- Chef 12.0 or later

### Cookbooks

* Cups
* Fop
* Nginx
* NodeJs
* Php
* Projects
* System

## Attributes

TODO: List your cookbook attributes here.

e.g.
### TiCo::default

<table>
  <tr>
    <th>Key</th>
    <th>Type</th>
    <th>Description</th>
    <th>Default</th>
  </tr>
  <tr>
    <td><tt>['TiCo']['bacon']</tt></td>
    <td>Boolean</td>
    <td>whether to include bacon</td>
    <td><tt>true</tt></td>
  </tr>
</table>

## Usage

### TiCo::default

Just include `TiCo` in your node's `run_list`:

```json
{
  "name":"my_node",
  "run_list": [
    "recipe[TiCo]"
  ]
}
```

## Contributing

1. Fork the repository on Github
2. Create a named feature branch (like `add_component_x`)
3. Write your change
4. Write tests for your change (if applicable)
5. Run the tests, ensuring they all pass
6. Submit a Pull Request using Github

## License and Authors

Authors: Rebel L

