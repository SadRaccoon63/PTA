document.addEventListener("DOMContentLoaded", () => {
    // Function to load student data
    const loadStudents_A3 = () => {
        fetch("A3_DB.php?action=getStudents_A3")
            .then((response) => response.json())
            .then((data) => {
                const students_a3Table = document.getElementById("studentsa3-Table").querySelector("tbody");
                students_a3Table.innerHTML = "";

                data.forEach((student) => {
                    const row = document.createElement("tr");
                    row.innerHTML = `
                        <td>${student.id}</td>
                        <td>${student.name}</td>
                        <td>${student.dorm}</td>
                        <td>${student.fingerprint_id}</td>
                    `;
                    students_a3Table.appendChild(row);
                });
            })
            .catch((error) => console.error("Error fetching students:", error));
    };

    // Function to load attendance records
    const loadAttendance_A3 = () => {
        fetch("A3_DB.php?action=getAttendance_A3")
            .then((response) => response.json())
            .then((data) => {
                const attendance_a3Table = document.getElementById("attendancea3-Table").querySelector("tbody");
                attendance_a3Table.innerHTML = "";

                data.forEach((record) => {
                    const row = document.createElement("tr");
                    row.innerHTML = `
                        <td>${record.id}</td>
                        <td>${record.fingerprint_id}</td>
                        <td>${record.timestamp}</td>
                    `;
                    attendance_a3Table.appendChild(row);
                });
            })
            .catch((error) => console.error("Error fetching attendance:", error));
    };

    // Call the functions to load data
    loadStudents_A3();
    loadAttendance_A3();
});
