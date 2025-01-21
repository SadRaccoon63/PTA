document.addEventListener("DOMContentLoaded", () => {
    // Function to load student data
    const loadStudents_A2 = () => {
        fetch("A2.php?action=getStudents_A2")
            .then((response) => response.json())
            .then((data) => {
                const students_a2Table = document.getElementById("studentsa2-Table").querySelector("tbody");
                students_a2Table.innerHTML = "";

                data.forEach((student) => {
                    const row = document.createElement("tr");
                    row.innerHTML = `
                        <td>${student.id}</td>
                        <td>${student.name}</td>
                        <td>${student.dorm}</td>
                        <td>${student.fingerprint_id}</td>
                    `;
                    students_a2Table.appendChild(row);
                });
            })
            .catch((error) => console.error("Error fetching students:", error));
    };

    // Function to load attendance records
    const loadAttendance_A2 = () => {
        fetch("A2.php?action=getAttendance_A2")
            .then((response) => response.json())
            .then((data) => {
                const attendance_a2Table = document.getElementById("attendancea2-Table").querySelector("tbody");
                attendance_a2Table.innerHTML = "";

                data.forEach((record) => {
                    const row = document.createElement("tr");
                    row.innerHTML = `
                        <td>${record.id}</td>
                        <td>${record.fingerprint_id}</td>
                        <td>${record.timestamp}</td>
                    `;
                    attendance_a2Table.appendChild(row);
                });
            })
            .catch((error) => console.error("Error fetching attendance:", error));
    };

    // Call functions to load data
    loadStudents_A2();
    loadAttendance_A2();
});
