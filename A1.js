document.addEventListener("DOMContentLoaded", () => {
    const loadStudents_A1 = () => {
        fetch("A1_DB.php?action=getStudents_A1")
            .then((response) => response.json())
            .then((data) => {
                const students_a1Table = document.getElementById("studentsa1-Table").querySelector("tbody");
                students_a1Table.innerHTML = "";

                data.forEach((student) => {
                    const row = document.createElement("tr");
                    row.innerHTML = `
                        <td>${student.id}</td>
                        <td>${student.name}</td>
                        <td>${student.dorm}</td>
                        <td>${student.fingerprint_id}</td>
                    `;
                    students_a1Table.appendChild(row);
                });
            })
            .catch((error) => console.error("Error fetching students:", error));
    };

    const loadAttendance_A1 = () => {
        fetch("A1_DB.php?action=getAttendance_A1")
            .then((response) => response.json())
            .then((data) => {
                const attendance_a1Table = document.getElementById("attendancea1-Table").querySelector("tbody");
                attendance_a1Table.innerHTML = "";

                data.forEach((record) => {
                    const row = document.createElement("tr");
                    row.innerHTML = `
                        <td>${record.id}</td>
                        <td>${record.fingerprint_id}</td>
                        <td>${record.timestamp}</td>
                    `;
                    attendance_a1Table.appendChild(row);
                });
            })
            .catch((error) => console.error("Error fetching attendance:", error));
    };

    loadStudents_A1();
    loadAttendance_A1();
});
