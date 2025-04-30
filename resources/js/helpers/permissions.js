export function hasRole(user, roleName) {
    return user?.roles?.some((role) => role.name === roleName);
}

export function hasPermission(user, permissionName) {
    return user?.permissions?.some(
        (permission) => permission.name === permissionName
    );
}
