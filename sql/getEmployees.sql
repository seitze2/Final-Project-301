SELECT *
FROM final_employees
JOIN final_paysalaries
ON final_employees.employeeID = final_paysalaries.employeeID
WHERE fullname LIKE :term