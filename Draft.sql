CREATE VIEW view_permission_role AS
SELECT id, name, role_id
FROM permissions
         LEFT JOIN role_has_permissions ON permissions.id = role_has_permissions.permission_id;
