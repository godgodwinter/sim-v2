import {
    S as e,
    g as t,
    m as i
} from "./vendor.153f79af.js";
const n = t;
n.registerPlugin(e);
i.data("mainState", (() => ({
    init: () => {
        n.to(".loading .logo", {
            opacity: 0,
            duration: .5
        }), n.to(".loading .left", {
            x: "-110%",
            duration: 1,
            delay: .6
        }), n.to(".loading .right", {
            x: "110%",
            duration: 1,
            delay: .6,
            onComplete: () => {
                document.querySelector(".loading").remove()
            }
        })
    },
    isDark: window.localStorage.getItem("dark") ? JSON.parse(window.localStorage.getItem("dark")) : !!window.matchMedia && window.matchMedia("(prefers-color-scheme: dark)").matches,
    toggleTheme() {
        var e;
        this.isDark = !this.isDark, e = this.isDark, window.localStorage.setItem("dark", e)
    }
}))), i.data("navbarState", (() => {
    let e = 0;
    return {
        init: function () {
            window.addEventListener("scroll", (() => {
                let t = window.pageYOffset || document.documentElement.scrollTop;
                t > e ? (this.scrollingDown = !0, this.scrollingUp = !1) : (this.scrollingDown = !1, this.scrollingUp = !0, 0 == t && (this.scrollingDown = !1, this.scrollingUp = !1)), e = t <= 0 ? 0 : t
            }))
        },
        scrollingDown: !1,
        scrollingUp: !1,
        isMobileMenuOpen: !1,
        toggleMobileMenu() {
            let e = document.getElementById("mobileMenu");
            this.isMobileMenuOpen ? (this.isMobileMenuOpen = !1, n.to(e, {
                height: 0,
                duration: .4
            })) : (this.isMobileMenuOpen = !0, n.fromTo(e, {
                height: 0
            }, {
                height: e.scrollHeight,
                duration: 2,
                ease: "elastic"
            }))
        }
    }
})), i.data("navbarLinksState", (() => ({
    navigationLinks: [{
        label: "LOGIN",
        link: "/dashboard"
    }
    // , {
    //     label: "GURU",
    //     link: "/dashboard"
    // }, {
    //     label: "KEPSEK",
    //     link: "/dashboard"
    // }, {
    //     label: "SISWA",
    //     link: "/siswa/tagihansiswa"
    // }, {
    //     label: "WALI MURID",
    //     link: "/dashboard"
    // }
],
    handelMouseEnter: e => {
        n.to(e.querySelector(".underline-link"), {
            opacity: 1,
            translateX: 0,
            duration: 1.5,
            ease: "elastic"
        })
    },
    handelMouseLeave: e => {
        n.to(e.querySelector(".underline-link"), {
            opacity: 0,
            translateX: "102%",
            duration: 1.5,
            ease: "elastic"
        })
    }
}))), i.data("introSectionState", (() => ({
    init: function () {
        this.$refs.showCase.style.transform = `perspective(${this.windowWidth}px) rotateX(45deg)`, window.addEventListener("resize", (() => {
            this.windowWidth = window.innerWidth, this.$refs.showCase.style.transform = `perspective(${this.windowWidth}px) rotateX(45deg)`
        })), n.timeline({
            scrollTrigger: {
                trigger: ".dashboard-showcase",
                start: "top center",
                end: "bottom center",
                scrub: !0,
                pin: !0
            }
        }).to(".dashboard-showcase", {
            opacity: 1,
            rotateX: 0,
            duration: 2,
            ease: "circ.out"
        })
    },
    windowWidth: window.innerWidth
}))), window.Alpine = i, window.Alpine.start();
