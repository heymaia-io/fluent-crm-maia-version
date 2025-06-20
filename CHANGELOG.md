# FluentCRM - Maia Custom Version Changelog

## Version: Maia Custom - Based on Original FluentCRM

**Date: June 19, 2025**

### Changes Made

#### Added Support for `maia_fcrm_manager` Capability

- **Enhanced Permission System** to recognize existing `maia_fcrm_manager` WordPress capability
- **Full Permissions Granted** to users with this capability:
  - Dashboard access (`fcrm_view_dashboard`)
  - Complete contact management (`fcrm_read_contacts`, `fcrm_manage_contacts`, `fcrm_manage_contacts_delete`, `fcrm_manage_contacts_export`)
  - Contact segmentation management (`fcrm_manage_contact_cats`, `fcrm_manage_contact_cats_delete`)
  - Email campaign management (`fcrm_read_emails`, `fcrm_manage_emails`, `fcrm_manage_email_delete`)
  - Email template management (`fcrm_manage_email_templates`)
  - Form management (`fcrm_manage_forms`)
  - Automation/funnel management (`fcrm_read_funnels`, `fcrm_write_funnels`, `fcrm_delete_funnels`)
  - Settings management (`fcrm_manage_settings`)

#### Code Changes

##### **PermissionManager.php** - Permission System Updates

- Updated `currentUserCan()` method to recognize `maia_fcrm_manager` capability as having full access to all FluentCRM features
- Updated `getUserPermissions()` method to grant all FluentCRM permissions to users with `maia_fcrm_manager` capability
- Ensures users with this capability have the same level of FluentCRM access as WordPress administrators

### Technical Implementation Details

The permission system modifications ensure that:

1. **Existing `maia_fcrm_manager` capability** is automatically recognized
2. **Full FluentCRM access** is granted without requiring WordPress administrator privileges
3. **Seamless integration** with existing FluentCRM permission system
4. **Capability-based access control** for dedicated FluentCRM managers

### Prerequisites

- The `maia_fcrm_manager` WordPress capability must already exist in the WordPress installation
- Users must be granted this capability through WordPress user management or plugins

### Usage

If the `maia_fcrm_manager` capability exists in WordPress:

1. Grant users this capability through WordPress Admin → Users or capability management plugins
2. Users will automatically have full access to all FluentCRM features
3. No additional configuration required

### Notes

- **Original FluentCRM codebase**: All files are from the original FluentCRM version
- **Minimal modifications**: Only permission recognition was modified, no capability creation
- **Backward compatibility**: All existing functionality remains unchanged
- **External capability dependency**: Assumes `maia_fcrm_manager` capability exists independently
- **Security**: Capability recognition only grants FluentCRM-specific permissions

---

**Base Version**: Original FluentCRM  
**Custom Modifications**: Maia FluentCRM Manager Capability Recognition  
**Maintained by**: Maia Development Team
