document.addEventListener('DOMContentLoaded', function() {
    // Referințe la elementele DOM din pagina de task-uri
    const inputTask = document.getElementById('task-input');
    const inputDeadline = document.getElementById('task-deadline');
    const btnAdauga = document.getElementById('add-btn');
    const listaTaskuri = document.getElementById('task-list');

    // Lista lunilor în limba română (pentru data adăugării)
    const luni = [
        "Ianuarie", "Februarie", "Martie", "Aprilie", "Mai", "Iunie",
        "Iulie", "August", "Septembrie", "Octombrie", "Noiembrie", "Decembrie"
    ];

    // Funcția principală pentru adăugarea unui task
    function adaugaTask() {
        const textTask = inputTask.value.trim();
        const deadline = inputDeadline.value; // Format yyyy-mm-dd

        if (textTask !== '') {
            // Creăm un nou element de listă
            const elementNou = document.createElement('li');

            // --- 1. Gestionarea datei de adăugare (ca în scriptul inițial) ---
            const dataCurenta = new Date();
            const zi = dataCurenta.getDate();
            const luna = luni[dataCurenta.getMonth()];
            const an = dataCurenta.getFullYear();
            const dataAdaugareFormatata = `${zi} ${luna} ${an}`;

            // --- 2. Formatarea deadline-ului ---
            let deadlineText = 'Nespecificat';
            if (deadline) {
                // Dacă există deadline, îl formatăm
                const deadlineDate = new Date(deadline + 'T00:00:00'); // Adaugă T00:00:00 pentru a evita problemele de fus orar
                const ziDead = deadlineDate.getDate();
                const lunaDead = luni[deadlineDate.getMonth()];
                const anDead = deadlineDate.getFullYear();
                deadlineText = `${ziDead} ${lunaDead} ${anDead}`;
            }

            // Adăugăm conținutul elementului
            elementNou.innerHTML = `
                <span class="task-text">${textTask}</span>
                <span class="task-info">
                    (Deadline: <strong class="deadline-data">${deadlineText}</strong>)
                    Adăugat la: ${dataAdaugareFormatata}
                </span>
                <button class="delete-btn">✕</button>
            `;
            
            // Adaugăm clasa 'urgent' dacă deadline-ul este în următoarele 3 zile (opțional)
            if (deadline && esteUrgent(deadlineDate)) {
                 elementNou.classList.add('urgent-task');
            }


            // Adăugăm elementul în listă (momentan fără salvare locală, doar vizual)
            listaTaskuri.appendChild(elementNou);

            // Adăugăm funcționalitatea de ștergere
            elementNou.querySelector('.delete-btn').addEventListener('click', function() {
                elementNou.remove();
            });

            // Golim câmpurile de input și focus
            inputTask.value = '';
            inputDeadline.value = '';
            inputTask.focus();
        }
    }
    
    // Funcție ajutătoare pentru a verifica urgența (opțional)
    function esteUrgent(deadlineDate) {
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        const diffTime = deadlineDate.getTime() - today.getTime();
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        return diffDays <= 3 && diffDays >= 0; // Urgent dacă e azi sau în următoarele 3 zile
    }

    // Adăugăm event listener pentru buton
    btnAdauga.addEventListener('click', adaugaTask);

    // Adăugăm event listener pentru tasta Enter în câmpul de input
    inputTask.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            adaugaTask();
        }
    });
});