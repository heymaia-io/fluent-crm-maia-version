<?php
/**
 * Maia FluentCRM Manager Role Setup Script
 * 
 * This script can be used to manually create or update the maia_fcrm_manager role
 * Run this from WordPress admin or via WP-CLI if needed
 */

// Ensure this is run within WordPress context
if (!defined('ABSPATH')) {
    exit('This script must be run within WordPress context.');
}

function create_maia_fcrm_manager_role() {
    // Check if FluentCRM is active
    if (!defined('FLUENTCRM')) {
        return new WP_Error('fluent_crm_not_active', 'FluentCRM plugin is not active.');
    }

    // Import PermissionManager to get all available permissions
    if (!class_exists('\FluentCrm\App\Services\PermissionManager')) {
        return new WP_Error('permission_manager_not_found', 'FluentCRM PermissionManager class not found.');
    }

    $allPermissions = \FluentCrm\App\Services\PermissionManager::pluginPermissions();
    
    // Prepare capabilities array for the role
    $capabilities = array();
    
    // Grant all FluentCRM permissions to the role
    foreach ($allPermissions as $permission) {
        $capabilities[$permission] = true;
    }
    
    // Add some basic WordPress capabilities that might be needed
    $capabilities['read'] = true;
    $capabilities['upload_files'] = true;
    
    // Create the role if it doesn't exist
    if (!get_role('maia_fcrm_manager')) {
        $role = add_role(
            'maia_fcrm_manager',
            __('Maia FluentCRM Manager', 'fluent-crm'),
            $capabilities
        );
        
        if ($role) {
            return array(
                'success' => true,
                'message' => 'Maia FluentCRM Manager role created successfully.',
                'capabilities' => array_keys($capabilities)
            );
        } else {
            return new WP_Error('role_creation_failed', 'Failed to create Maia FluentCRM Manager role.');
        }
    } else {
        // If role exists, update its capabilities
        $role = get_role('maia_fcrm_manager');
        foreach ($capabilities as $cap => $grant) {
            $role->add_cap($cap, $grant);
        }
        
        return array(
            'success' => true,
            'message' => 'Maia FluentCRM Manager role already exists and capabilities updated.',
            'capabilities' => array_keys($capabilities)
        );
    }
}

// Function to remove the role (use with caution)
function remove_maia_fcrm_manager_role() {
    $role = get_role('maia_fcrm_manager');
    if ($role) {
        // First, check if any users have this role
        $users_with_role = get_users(array('role' => 'maia_fcrm_manager'));
        
        if (!empty($users_with_role)) {
            return new WP_Error('users_have_role', 'Cannot remove role as users are assigned to it. Please change their roles first.');
        }
        
        remove_role('maia_fcrm_manager');
        return array('success' => true, 'message' => 'Maia FluentCRM Manager role removed successfully.');
    } else {
        return new WP_Error('role_not_found', 'Maia FluentCRM Manager role does not exist.');
    }
}

// Example usage (uncomment to run):
// $result = create_maia_fcrm_manager_role();
// if (is_wp_error($result)) {
//     echo 'Error: ' . $result->get_error_message();
// } else {
//     echo 'Success: ' . $result['message'];
//     echo "\nCapabilities granted: " . implode(', ', $result['capabilities']);
// }
