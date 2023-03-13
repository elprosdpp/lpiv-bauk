# ROLE EDIT DETAIL
CREATE VIEW view_permission_role AS
SELECT id, name, role_id
FROM permissions
         LEFT JOIN role_has_permissions ON permissions.id = role_has_permissions.permission_id;

# VIEW INDEX ROLE
CREATE VIEW view_index_permission_role AS
SELECT role_has_permissions.role_id, GROUP_CONCAT(permissions.name) AS name
FROM permissions
         LEFT JOIN role_has_permissions ON permissions.id = role_has_permissions.permission_id
GROUP BY role_has_permissions.role_id;

# VIEW INDEX ROLE WITH 2 JOIN TABLE
CREATE VIEW view_index_permission_role AS
SELECT xs.role_id,r.name, GROUP_CONCAT(p.name) AS permission_name
FROM permissions p, roles r, role_has_permissions xs
WHERE xs.permission_id = p.id
  AND xs.role_id = r.id
GROUP BY xs.role_id;
