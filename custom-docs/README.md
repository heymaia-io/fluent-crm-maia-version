# FluentCRM - Maia Custom Version

This is a customized version of FluentCRM with enhanced permission recognition for the existing `maia_fcrm_manager` WordPress capability.

## Custom Features Added

### Maia FluentCRM Manager Capability Support

We've enhanced FluentCRM to automatically recognize and grant full access to users with the existing `maia_fcrm_manager` WordPress capability.

#### Features:

- **Automatic Recognition**: FluentCRM automatically detects users with `maia_fcrm_manager` capability
- **Full FluentCRM Access**: Complete access to all contacts, campaigns, automations, forms, and settings
- **Non-Admin Capability**: Doesn't require WordPress administrator privileges
- **Seamless Integration**: Works with existing WordPress capability management

#### Permissions Granted:

- Dashboard access
- Contact management (create, read, update, delete, export)
- Tag and list management
- Email campaign management
- Email template management
- Form management
- Automation/funnel management
- Settings management

## Prerequisites

- The `maia_fcrm_manager` WordPress capability must already exist in your WordPress installation
- This plugin only recognizes the capability; it doesn't create it

## Installation

1. Ensure the `maia_fcrm_manager` capability exists in WordPress
2. Upload the customized FluentCRM files to your WordPress installation
3. Activate the plugin - users with `maia_fcrm_manager` capability will automatically have full FluentCRM access

**Note**: This custom version has automatic updates disabled to preserve customizations.

## Using the Capability

If you have users granted the `maia_fcrm_manager` capability:

1. They will automatically have full access to FluentCRM features
2. No additional configuration is needed
3. The access is equivalent to WordPress administrators within FluentCRM

To grant users the capability:

1. Use WordPress capability management plugins (like User Role Editor)
2. Or programmatically grant the capability: `$user->add_cap('maia_fcrm_manager')`
3. Users will immediately have full FluentCRM access

## Files Modified

The following files have been modified from the original FluentCRM:

- `fluent-crm.php` - Updated plugin header and disabled automatic updates
- `app/Services/PermissionManager.php` - Enhanced permission recognition for `maia_fcrm_manager` capability

## Support

For questions or issues related to these custom modifications, contact the Maia development team.

## Original FluentCRM

This custom version is based on the original FluentCRM plugin. All original functionality remains intact, with only enhanced permission recognition for the `maia_fcrm_manager` capability.

---

**Version**: Maia Custom  
**Based on**: Original FluentCRM  
**Last Updated**: June 19, 2025
