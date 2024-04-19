var tl = gsap.timeline()
tl.from("nav a , nav button", {
    y: -100,
    opacity: 0,
    duration: 1,
    stagger: 0.2,


})
tl.from(".intro ", {
    y: 100,
    opacity: 0,


})
tl.from(".header h3", {
    y: 100,
    opacity: 0,


})
tl.from(".header ", {
    scale:0,
    opacity: 0,


})
tl.to(".header ", {
    y:30,
    repeat:-1,
    duration:1,
    yoyo:true,


})


tl.from(".header h2", {
    y: 100,
    opacity: 0,


})
tl.from(".page2 h1", {
    y: -100,
    duration: 2,
    scale: 0,
    opacity: 0,
    scrollTrigger: {
        trigger: ".page2 h1",
        scroller: "body",
        start: "top 70%",
        end: "top 30%",
        scrub: true,
    }
})




tl.to(".page3 h1", {
    transform: "translateX(-100%)",
    fontWeight: 100,
    delay: 1.5, // Add a delay before the scrolling starts
    scrollTrigger: {
        trigger: ".page3",
        scroller: "body",
        markers: true,
        start: "top 0",
        end: "top -200%", // Adjust the end position
        scrub: 2, // Adjust the scrub value for a slower scrolling action
        pin: true,
    }
});
tl.from(".page5 h2 ", {
    x: -100,
    duration: 2,
    scale: 0,
    opacity: 0,
    scrollTrigger: {
        trigger: ".page5 h2 ",
        scroller: "body",
        start: "top 70%",
        end: "top 30%",
        scrub: true,
    }
})

tl.from(".hero h1, .hero h3", {
    y:200, // Move elements from left to right (negative value)
    scale: 0,
    opacity: 1,
    
    stagger:0.5,
    scrollTrigger: {
        trigger: ".hero h1, .hero h3 ",
        scroller: "body",
        start: "top 150%",
        end: "top 20%",
        duration: 4,
        scrub: true,
        ease: "power2.out", 
        
        
       
    }
   
   
});













