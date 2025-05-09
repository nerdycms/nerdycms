const webPushClickKey = "webPushClick";

navigator.serviceWorker.register('/pushWorker/handle', {scope: '/'}).then(() => {
    }, e => {
    }
);


window.onclick = () => {
    localStorage.setItem(webPushClickKey, "1");
}

window.onload = () => {
    setInterval(async function () {
        if (localStorage.getItem(webPushClickKey) !== "1") {
            return;
        }

        if (Notification.permission === "default") {
            Notification.requestPermission().then(perm => {
                if (Notification.permission === "granted") {
                    regWorker().catch(err => console.error(err));
                } else {
                }
            });
        } else if (Notification.permission === "granted") {
            let registers = await navigator.serviceWorker.getRegistrations().then(registrations => {
                return registrations;
            });
            let workedRegistered = false;

            Array.from(registers).forEach(function (registration) {
                if (registration.active.scriptURL.includes('pushWorker.js')) {
                    workedRegistered = true;
                }
            });

            if (!workedRegistered) {
                regWorker().catch(err => console.error(err));
            }
        }
    }, 2000);
}

async function regWorker () {
    const publicKey = window.pushServerKey;

    navigator.serviceWorker.ready
        .then(reg => {
            reg.pushManager.subscribe({
                userVisibleOnly: true,
                applicationServerKey: publicKey
            }).then(
                sub => {
                    var data = new FormData();
                    data.append("sub", JSON.stringify(sub));
                    fetch("/web-push", { method: "POST", body : data })
                        .then()
                        .then()
                        .catch();
                },

                err => console.error(err)
            );
        }).catch(function (reason) {
            console.log(reason);
    });
}