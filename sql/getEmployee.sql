SELECT *
FROM final_employees
JOIN final_paysalaries
ON final_employees.employeeID = final_paysalaries.employeeID
WHERE final_employees.employeeID = :employeeID